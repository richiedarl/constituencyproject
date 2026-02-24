<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\ProjectMedia;
use App\Models\Application;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminApplicationController extends Controller
{
    //
public function adminIndex(Request $request)
{
    $perPage = $request->get('per_page', 20);

    $applications = Application::with(['project', 'contractor.user', 'contractor.skills'])
        ->latest()
        ->paginate($perPage)
        ->through(function($app) {
            $app->status_badge = $this->getStatusBadge($app->status);
            $app->has_contractor = $app->contractor !== null;
            return $app;
        });

    $stats = [
        'total' => Application::count(),
        'pending' => Application::where('status', Application::STATUS_PENDING)->count(),
        'approved' => Application::where('status', Application::STATUS_APPROVED)->count(),
        'cancelled' => Application::where('status', Application::STATUS_CANCELLED)->count(),
    ];

    return view('admin.applications.index', compact('applications', 'stats'));
}

    public function index()
{
    $applications = Application::with([
        'project',
        'contractor.user',
        'contractor.skills'
    ])->latest()->paginate(12);

    $stats = [
        'total' => Application::count(),
        'pending' => Application::where('status', 'pending')->count(),
        'approved' => Application::where('status', 'approved')->count(),
    ];

    return view('admin.applications.index', compact('applications', 'stats'));
}

public function show(Application $application)
{
    $application->load([
        'project',
        'candidate.user',
        'candidate.positions',
        'contractor.user',
        'contractor.skills',
        'contributor.user'
    ]);

    return view('admin.applications.show', compact('application'));
}


public function pending()
{
    $applications = Application::with([
        'project',
        'contractor.user',
        'contractor.skills'
    ])
    ->where('status', 'pending')
    ->latest()
    ->get();

    $stats = [
        'total_pending' => $applications->count(),
        'unique_contractors' => $applications->pluck('contractor_id')->unique()->count(),
        'unique_projects' => $applications->pluck('project_id')->unique()->count(),
        'oldest_pending' => optional($applications->last())->created_at?->diffInDays(now()) ?? 0,
        'high_priority' => $applications->filter(fn($a) => $a->created_at->diffInDays(now()) > 7)->count(),
        'avg_waiting_days' => round($applications->avg(fn($a) => $a->created_at->diffInDays(now()))),
    ];

    return view('admin.applications.pending', compact('applications', 'stats'));
}


public function approve(Application $application)
{
     // 🔒 Prevent double approval
    if ($application->status === 'approved') {
        return back()->with('error', 'This application has already been approved.');
    }

    // 🔒 Ensure payment confirmed
    if (!$application->candidate->paid) {
        return back()->with('error', 'Candidate has not completed payment.');
    }

    DB::beginTransaction();

    try {

        $application->status = 'approved';
        $application->approved_at = now();
        $application->save();

        // Handle based on type
        if ($application->type === 'candidate' && $application->candidate) {

            $application->candidate->approved = true;
            $application->candidate->save();

            if ($application->paid) {

                // Prevent double credit
                $existingTransaction = Transaction::where('reference', 'app_fee_'.$application->id)->first();

                if (!$existingTransaction) {

                    $admin = User::find(1);

                    $admin->wallet_balance += $application->application_fee;
                    $admin->save();

                    $application->project->update([
                        "is_active" => 1
                    ]);

                    Transaction::create([
                        'user_id' => 1,
                        'amount' => $application->application_fee,
                        'type' => 'credit',
                        'reference' => 'app_fee_'.$application->id,
                        'description' => 'Candidate Application Fee'
                    ]);
                }
            }
        }

        if ($application->type === 'contractor' && $application->contractor) {
            $application->contractor->approved = true;
            $application->contractor->save();
        }

        if ($application->type === 'contributor' && $application->contributor) {
            $application->contributor->approved = true;
            $application->contributor->save();
        }

        if ($application->type === 'candidate' && $application->candidate) {
            $application->candidate->approved = true;
            $application->candidate->save();
        }

        DB::commit();

        return back()->with('success', 'Application approved successfully.');

    } catch (\Exception $e) {

        DB::rollBack();
        return back()->with('error', 'Approval failed.');
    }
}


}
