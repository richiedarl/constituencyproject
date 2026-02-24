<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Donation;
use App\Models\Project;
use App\Models\Contractor;
use App\Models\PendingFundingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    /**
     * Show all applications/donations for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $items = $this->getUserItems($user);

        return view('user.applications.index', [
            'applications' => $items,
            'stats' => $this->getUserStats($items)
        ]);
    }

    /**
     * Show approved applications/donations.
     */
    public function approved(Request $request)
    {
        $user = Auth::user();
        $items = $this->getUserItems($user)->where('status', 'approved');

        return view('user.applications.index', [
            'applications' => $items,
            'stats' => $this->getUserStats($this->getUserItems($user))
        ]);
    }

    /**
 * Show a single application/donation details.
 */
public function show(Application $application)
{
    $user = Auth::user();

    // Authorization check
    if ($user->contractor && $application->contractor_id !== $user->contractor->id) {
        abort(403);
    }

    if ($user->candidate) {
        $projectIds = Project::where('candidate_id', $user->candidate->id)->pluck('id');
        if (!in_array($application->project_id, $projectIds->toArray())) {
            abort(403);
        }
    }

    // Load relationships
    $application->load(['project', 'contractor.user', 'contributor.user']);

    // Set type for display
    if ($application->contractor_id) {
        $application->type = 'Application';
    } elseif ($application->contributor_id) {
        $application->type = 'Donation';
    }

    return view('user.applications.show', compact('application'));
}
    /**
     * Show pending applications/donations.
     */

    public function pending(Request $request)
    {
        $user = Auth::user();
        $items = $this->getUserItems($user)->where('status', 'pending');

        return view('user.applications.index', [
            'applications' => $items,
            'stats' => $this->getUserStats($this->getUserItems($user))
        ]);
    }

    /**
     * Show cancelled/rejected applications.
     */
    public function cancelled(Request $request)
    {
        $user = Auth::user();
        $items = $this->getUserItems($user)->filter(function($item) {
            return in_array($item->status, ['cancelled', 'rejected', 'failed']);
        });

        return view('user.applications.index', [
            'applications' => $items,
            'stats' => $this->getUserStats($this->getUserItems($user))
        ]);
    }

    /**
     * Get all items based on user role.
     */
    private function getUserItems($user)
    {
        if ($user->contractor) {
            // Contractors see their applications
            return Application::with('project')
                ->where('contractor_id', $user->contractor->id)
                ->latest()
                ->get()
                ->map(function($app) {
                    $app->type = 'Application';
                    $app->project_name = $app->project?->title;
                    return $app;
                });
        }

        if ($user->contributor) {
            // Contributors see donations and funding requests
            $donations = Donation::with('project')
                ->where('contributor_id', $user->contributor->id)
                ->get()
                ->map(function($donation) {
                    $donation->type = 'Donation';
                    $donation->status = $donation->approved ? 'approved' : 'pending';
                    $donation->project_name = $donation->project?->title;
                    return $donation;
                });

            $funding = PendingFundingRequest::where('user_id', $user->id)
                ->latest()
                ->get()
                ->map(function($fund) {
                    $fund->type = 'Wallet Funding';
                    $fund->project_name = 'Wallet Top-up';
                    $fund->amount = $fund->amount;
                    return $fund;
                });

            return $donations->concat($funding)->sortByDesc('created_at');
        }

        if ($user->candidate) {
            // Candidates see applications and donations for their projects
            $projectIds = Project::where('candidate_id', $user->candidate->id)->pluck('id');

            $applications = Application::with(['project', 'contractor.user'])
                ->whereIn('project_id', $projectIds)
                ->get()
                ->map(function($app) {
                    $app->type = 'Application';
                    $app->project_name = $app->project?->title;
                    $app->from = $app->contractor?->user?->name;
                    return $app;
                });

            $donations = Donation::with(['project', 'contributor.user'])
                ->whereIn('project_id', $projectIds)
                ->get()
                ->map(function($donation) {
                    $donation->type = 'Donation';
                    $donation->status = $donation->approved ? 'approved' : 'pending';
                    $donation->project_name = $donation->project?->title;
                    $donation->from = $donation->contributor?->user?->name;
                    return $donation;
                });

            return $applications->concat($donations)->sortByDesc('created_at');
        }

        return collect();
    }

    /**
     * Get statistics from items collection.
     */
    private function getUserStats($items)
    {
        return [
            'total' => $items->count(),
            'pending' => $items->where('status', 'pending')->count(),
            'approved' => $items->where('status', 'approved')->count(),
            'cancelled' => $items->filter(function($item) {
                return in_array($item->status, ['cancelled', 'rejected', 'failed']);
            })->count()
        ];
    }

    /**
     * Store a new contractor application.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'expected_rate' => 'nullable|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $contractor = Contractor::where('user_id', Auth::id())->first();

            if (!$contractor || !$contractor->approved) {
                return back()->with('error', 'You need an approved contractor profile to apply.');
            }

            // Check if already applied
            $exists = Application::where('contractor_id', $contractor->id)
                ->where('project_id', $project->id)
                ->exists();

            if ($exists) {
                return back()->with('error', 'You have already applied for this project.');
            }

            // Check contractor limit
            $approvedCount = Application::where('project_id', $project->id)
                ->where('status', 'approved')
                ->count();

            if ($approvedCount >= ($project->contractor_count ?? 1)) {
                return back()->with('error', 'This project has reached its contractor limit.');
            }

            // Create application
            Application::create([
                'contractor_id' => $contractor->id,
                'project_id' => $project->id,
                'status' => 'pending',
                'applied_at' => now()
            ]);

            DB::commit();

            return redirect()->route('contractor.my.projects')
                ->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Application failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit application.');
        }
    }

    /**
     * Cancel an application.
     */
    public function cancel(Application $application)
    {
        // Check if user owns this application
        if (!$application->contractor || $application->contractor->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($application->status !== 'pending') {
            return back()->with('error', 'Only pending applications can be cancelled.');
        }

        $application->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return back()->with('success', 'Application cancelled successfully.');
    }
}
