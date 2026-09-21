<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Project;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        return redirect()->route('candidates.index');
    }

    public function show(Candidate $candidate)
    {
        return redirect()->route('candidate.public.show', $candidate->slug);
    }

    public function attachProject(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $project = Project::findOrFail($validated['project_id']);
        $project->update(['candidate_id' => $candidate->id]);

        return back()->with('success', 'Project added to the candidate portfolio.');
    }
}
