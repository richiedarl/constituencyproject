<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Application;

class ContributorController extends Controller
{
    // Show the Apply page
    public function showApplyForm(Project $project)
    {
        $user = auth()->user();

        // If not a contributor, redirect to registration
        if (!$user->contributor) {
            return redirect()->route('contributor.register')
                             ->with('warning', 'You must register as a contributor first.');
        }

        // If already applied for this project
        $existing = Application::where('project_id', $project->id)
                               ->where('contributor_id', $user->contributor->id)
                               ->first();

        if ($existing) {
            return back()->with('info', 'You have already applied for this project.');
        }

        return view('user.contributors.apply', compact('project'));
    }

    // Handle the application submission
    public function apply(Request $request, Project $project)
    {
        $contributor = auth()->user()->contributor;

        if (!$contributor) {
            return redirect()->route('contributor.register');
        }

        Application::create([
            'contributor_id' => $contributor->id,
            'project_id'     => $project->id,
            'status'         => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Application submitted successfully.');
    }
}
