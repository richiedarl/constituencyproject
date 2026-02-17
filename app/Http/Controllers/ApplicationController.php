<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApplicationController extends Controller
{
    //
       // Admin: View all applications
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

public function index(Request $request)
{
    $contractor = auth()->user()->contractor;

    if (!$contractor) {
        return redirect()->route('contractor.register')
            ->with('info', 'Please register as a contractor first.');
    }

    $perPage = $request->get('per_page', 20);

    $applications = $contractor->applications()
        ->with('project')
        ->latest()
        ->paginate($perPage)
        ->through(function($app) {
            $app->status_badge = $this->getStatusBadge($app->status);
            return $app;
        });

    $stats = [
        'total' => $contractor->applications()->count(),
        'pending' => $contractor->applications()->where('status', Application::STATUS_PENDING)->count(),
        'approved' => $contractor->applications()->where('status', Application::STATUS_APPROVED)->count(),
        'cancelled' => $contractor->applications()->where('status', Application::STATUS_CANCELLED)->count(),
    ];

    return view('user.contractors.applications.index', compact('applications', 'stats'));
}

}
