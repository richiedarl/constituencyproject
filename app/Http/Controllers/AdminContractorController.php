<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminContractorController extends Controller
{
    /**
     * Display a listing of contractors.
     */
    public function index()
    {
        $contractors = Contractor::with(['user', 'projects'])
            ->withCount('projects')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get unique occupations for filter
        $occupations = Contractor::whereNotNull('occupation')
            ->distinct()
            ->pluck('occupation')
            ->toArray();

        return view('admin.contractors.index', compact('contractors', 'occupations'));
    }

    /**
     * Show the form for creating a new contractor.
     */
    public function create()
    {
        return view('admin.contractors.create');
    }

    /**
     * Store a newly created contractor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'skills' => 'nullable|array',
            'photo' => 'nullable|image|max:2048',
            'approved' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('contractors', 'public');
        }

        Contractor::create($validated);

        return redirect()->route('admin.contractors.index')
            ->with('success', 'Contractor created successfully.');
    }

    /**
     * Display the specified contractor.
     */
    public function show(Contractor $contractor)
    {
        $contractor->load(['user', 'projects', 'applications' => function($q) {
            $q->with('project')->latest();
        }]);

        return view('admin.contractors.show', compact('contractor'));
    }

    /**
     * Show the form for editing the specified contractor.
     */
    public function edit(Contractor $contractor)
    {
        return view('admin.contractors.edit', compact('contractor'));
    }

    /**
     * Update the specified contractor.
     */
    public function update(Request $request, Contractor $contractor)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'skills' => 'nullable|array',
            'photo' => 'nullable|image|max:2048',
            'approved' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('contractors', 'public');
        }

        $contractor->update($validated);

        return redirect()->route('admin.contractors.index')
            ->with('success', 'Contractor updated successfully.');
    }

    /**
     * Remove the specified contractor.
     */
    public function destroy(Contractor $contractor)
    {
        // Check if contractor has any approved applications
        if ($contractor->applications()->where('status', 'approved')->exists()) {
            return redirect()->route('admin.contractors.index')
                ->with('error', 'Cannot delete contractor with approved project assignments.');
        }

        $contractor->delete();

        return redirect()->route('admin.contractors.index')
            ->with('success', 'Contractor deleted successfully.');
    }

    /**
     * Get available projects for a contractor.
     */
    public function getAvailableProjects(Contractor $contractor)
    {
        // Get all active projects that are not completed
        $projects = Project::with(['phases', 'applications' => function($q) {
                $q->where('status', 'approved');
            }])
            ->whereIn('status', ['planning', 'ongoing'])
            ->where('is_active', true)
            ->get()
            ->filter(function($project) use ($contractor) {
                // Check if project needs more contractors
                $approvedCount = $project->applications->count();

                // Skip if project already has enough contractors
                if ($approvedCount >= ($project->contractor_count ?? 1)) {
                    return false;
                }

                // Check if contractor is already assigned to this project
                $existingAssignment = Application::where('project_id', $project->id)
                    ->where('contractor_id', $contractor->id)
                    ->where('status', 'approved')
                    ->exists();

                return !$existingAssignment;
            })
            ->map(function($project) {
                $approvedCount = $project->applications->count();

                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'status' => $project->status,
                    'full_location' => $project->full_location,
                    'start_date' => $project->start_date?->format('Y-m-d'),
                    'contractor_count' => $project->contractor_count ?? 1,
                    'approved_contractors_count' => $approvedCount,
                    'slots_available' => ($project->contractor_count ?? 1) - $approvedCount
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    /**
     * Assign contractor to a project.
     */
    public function assignProject(Request $request, Contractor $contractor)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);

        try {
            DB::beginTransaction();

            $project = Project::findOrFail($validated['project_id']);

            // Check if project has available slots
            $approvedCount = Application::where('project_id', $project->id)
                ->where('status', Application::STATUS_APPROVED)
                ->count();

            if ($approvedCount >= ($project->contractor_count ?? 1)) {
                return redirect()->back()
                    ->with('error', 'This project already has the maximum number of contractors assigned.');
            }

            // Check if contractor is already assigned
            $existingAssignment = Application::where('project_id', $project->id)
                ->where('contractor_id', $contractor->id)
                ->whereIn('status', [Application::STATUS_APPROVED, Application::STATUS_PENDING])
                ->exists();

            if ($existingAssignment) {
                return redirect()->back()
                    ->with('error', 'Contractor is already assigned or pending for this project.');
            }

            // Create new application (assignment)
            Application::create([
                'contractor_id' => $contractor->id,
                'project_id' => $project->id,
                'status' => Application::STATUS_APPROVED,
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            DB::commit();

            return redirect()->route('admin.contractors.index')
                ->with('success', 'Contractor successfully assigned to project.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to assign contractor. Please try again.');
        }
    }

    /**
     * Toggle contractor approval status.
     */
    public function toggleApproval(Contractor $contractor)
    {
        $contractor->update([
            'approved' => !$contractor->approved
        ]);

        $status = $contractor->approved ? 'approved' : 'pending';

        return redirect()->back()
            ->with('success', "Contractor status changed to {$status}.");
    }
}
