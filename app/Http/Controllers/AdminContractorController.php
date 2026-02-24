<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminContractorController extends Controller
{

    /**
     * Display a listing of contractors (Your route: GET /contractors)
     */
    public function index()
{
    $contractors = Contractor::with('user')
        ->withCount([
            'applications as approved_projects_count' => function ($q) {
                $q->where('status', Application::STATUS_APPROVED);
            }
        ])
        ->latest()
        ->paginate(15);

    $occupations = Contractor::whereNotNull('occupation')
        ->distinct()
        ->pluck('occupation');

    return view('admin.contractors.index', compact(
        'contractors',
        'occupations'
    ));
}


    /**
     * Show the form for creating a new contractor.
     */
    public function create()
    {
        // Get users who don't already have contractor profiles
        $users = User::whereDoesntHave('contractor')
            ->orderBy('name')
            ->get();

        return view('admin.contractors.create', compact('users'));
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
            'skills.*' => 'string',
            'photo' => 'nullable|image|max:2048',
            'approved' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Check if user already has a contractor profile
            $existingContractor = Contractor::where('user_id', $validated['user_id'])->first();

            if ($existingContractor) {
                return redirect()->back()
                    ->with('error', 'This user already has a contractor profile.')
                    ->withInput();
            }

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('contractors', 'public');
            }

            $validated['approved'] = $request->has('approved');

            Contractor::create($validated);

            DB::commit();

            return redirect()->route('admin.contractors.index')
                ->with('success', 'Contractor created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Contractor creation failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create contractor. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified contractor (Your route: GET /contractors/{contractor})
     */
    public function show(Contractor $contractor)
{
    $contractor->load([
        'user',
        'skills',
        'applications' => function ($q) {
            $q->with('project')->latest();
        }
    ]);

    $approvedProjectsCount = $contractor->applications()
        ->where('status', Application::STATUS_APPROVED)
        ->count();

    return view('admin.contractors.show', compact(
        'contractor',
        'approvedProjectsCount'
    ));
}


    /**
     * Show the form for editing the specified contractor (Your route: GET /contractors/{contractor}/edit)
     */
    public function edit(Contractor $contractor)
    {
        $contractor->load('user');
        return view('admin.contractors.edit', compact('contractor'));
    }

    /**
     * Update the specified contractor (Your route: PUT /contractors/{contractor})
     */
    public function update(Request $request, Contractor $contractor)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'photo' => 'nullable|image|max:2048',
            'approved' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($contractor->photo) {
                    \Storage::disk('public')->delete($contractor->photo);
                }
                $validated['photo'] = $request->file('photo')->store('contractors', 'public');
            }

            $validated['approved'] = $request->has('approved');

            $contractor->update($validated);

            DB::commit();

            return redirect()->route('admin.contractors.index')
                ->with('success', 'Contractor updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Contractor update failed', [
                'contractor_id' => $contractor->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update contractor. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified contractor (Your route: DELETE /contractors/{contractor})
     */
    public function destroy(Contractor $contractor)
    {
        try {
            DB::beginTransaction();

            // Check if contractor has any approved applications
            if ($contractor->applications()->where('status', Application::STATUS_APPROVED)->exists()) {
                return redirect()->route('admin.contractors.index')
                    ->with('error', 'Cannot delete contractor with approved project assignments.');
            }

            // Delete photo if exists
            if ($contractor->photo) {
                \Storage::disk('public')->delete($contractor->photo);
            }

            // Delete related applications
            $contractor->applications()->delete();

            // Delete contractor
            $contractor->delete();

            DB::commit();

            return redirect()->route('admin.contractors.index')
                ->with('success', 'Contractor deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Contractor deletion failed', [
                'contractor_id' => $contractor->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.contractors.index')
                ->with('error', 'Failed to delete contractor. Please try again.');
        }
    }

    /**
     * Get available projects for a contractor (Your route: /admin/professionals/{contractor}/available-projects)
     */
    /**
 * Get available projects for a contractor
 */
public function getAvailableProjects(Contractor $contractor)
{
    $projects = Project::query()
        ->withCount(['applications as approved_count' => function ($q) {
            $q->where('status', Application::STATUS_APPROVED);
        }])
        ->whereDoesntHave('applications', function ($q) use ($contractor) {
            $q->where('contractor_id', $contractor->id)
              ->where('status', Application::STATUS_APPROVED);
        })
        ->whereRaw('approved_count < contractor_count')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($projects);
}

public function assignProjectPage(Contractor $contractor)
{
    // Load all projects
    $projects = Project::with('applications')->get();

    return view('admin.contractors.assign-projects', compact('contractor', 'projects'));
}

    /**
     * Assign contractor to a project (Your route: /admin/professionals/{contractor}/assign-project)
     */
 public function assignProject(Request $request, Contractor $contractor)
{
    $request->validate([
        'project_id' => ['required', 'exists:projects,id'],
    ]);

    Application::firstOrCreate(
        [
            'project_id'    => $request->project_id,
            'contractor_id' => $contractor->id,
        ],
        [
            'status'        => Application::STATUS_APPROVED,
            'approved_at'   => now(),
            'approved_by'   => auth()->id(),
        ]
    );

    return back()->with('success', 'Project assigned successfully.');
}


    /**
     * Toggle contractor approval status (Your route: /admin/professionals/{contractor}/toggle-approval)
     */
 public function toggleApproval(Contractor $contractor)
{
    $contractor->update([
        'approved' => ! $contractor->approved,
    ]);

    return back()->with(
        'success',
        $contractor->approved
            ? 'Contractor approved successfully.'
            : 'Contractor approval revoked.'
    );
}


    /**
     * Get contractor assignments (Your route: /admin/professionals/{contractor}/assignments)
     */
    public function getAssignments(Contractor $contractor)
    {
        try {
            $assignments = $contractor->applications()
                ->with(['project' => function($q) {
                    $q->select('id', 'title', 'status', 'start_date', 'completion_date');
                }])
                ->latest()
                ->get()
                ->map(function($application) {
                    return [
                        'id' => $application->id,
                        'project_id' => $application->project_id,
                        'project_title' => $application->project->title,
                        'project_status' => $application->project->status,
                        'assignment_status' => $application->status,
                        'assigned_at' => $application->approved_at?->format('Y-m-d H:i:s'),
                        'start_date' => $application->project->start_date?->format('Y-m-d'),
                        'end_date' => $application->project->completion_date?->format('Y-m-d')
                    ];
                });

            return response()->json([
                'success' => true,
                'assignments' => $assignments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch assignments.'
            ], 500);
        }
    }

    /**
     * Bulk assign professionals to project (Your route: /admin/professionals/bulk-assign)
     */
    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'contractor_ids' => 'required|array',
            'contractor_ids.*' => 'exists:contractors,id'
        ]);

        try {
            DB::beginTransaction();

            $project = Project::findOrFail($validated['project_id']);
            $maxContractors = $project->contractor_count ?? 1;

            // Get current approved count
            $currentApproved = Application::where('project_id', $project->id)
                ->where('status', Application::STATUS_APPROVED)
                ->count();

            // Check if we have enough slots
            $availableSlots = $maxContractors - $currentApproved;

            if (count($validated['contractor_ids']) > $availableSlots) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$availableSlots} slot(s) available for this project."
                ], 422);
            }

            $assigned = [];
            $skipped = [];

            foreach ($validated['contractor_ids'] as $contractorId) {
                // Check if already assigned
                $exists = Application::where('project_id', $project->id)
                    ->where('contractor_id', $contractorId)
                    ->whereIn('status', [Application::STATUS_APPROVED, Application::STATUS_PENDING])
                    ->exists();

                if (!$exists) {
                    Application::create([
                        'contractor_id' => $contractorId,
                        'project_id' => $project->id,
                        'status' => Application::STATUS_APPROVED,
                        'approved_at' => now(),
                        'approved_by' => auth()->id()
                    ]);
                    $assigned[] = $contractorId;
                } else {
                    $skipped[] = $contractorId;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($assigned) . ' contractor(s) assigned successfully.',
                'assigned' => $assigned,
                'skipped' => $skipped
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign contractors.'
            ], 500);
        }
    }

    /**
     * Get project candidates (Your route: /admin/professionals/project/{project}/candidates)
     */
    public function getProjectCandidates(Project $project)
    {
        try {
            // Get already assigned contractor IDs
            $assignedIds = Application::where('project_id', $project->id)
                ->whereIn('status', [Application::STATUS_APPROVED, Application::STATUS_PENDING])
                ->pluck('contractor_id')
                ->toArray();

            // Get eligible contractors
            $candidates = Contractor::with('user')
                ->where('approved', true)
                ->whereNotIn('id', $assignedIds)
                ->get()
                ->map(function($contractor) {
                    return [
                        'id' => $contractor->id,
                        'name' => $contractor->user->name ?? 'Unknown',
                        'photo' => $contractor->photo ? asset('storage/' . $contractor->photo) : null,
                        'occupation' => $contractor->occupation,
                        'skills' => $contractor->skills,
                        'district' => $contractor->district,
                        'phone' => $contractor->phone,
                        'previous_projects' => $contractor->projects()->count()
                    ];
                });

            return response()->json([
                'success' => true,
                'candidates' => $candidates,
                'project' => [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slots_filled' => count($assignedIds),
                    'total_slots' => $project->contractor_count ?? 1
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch candidates.'
            ], 500);
        }
    }

    // Vendor routes aliases (These call the same methods)
    public function eligibleProjects(Contractor $contractor)
    {
        return $this->getAvailableProjects($contractor);
    }

    public function assignToProject(Request $request, Contractor $contractor)
    {
        return $this->assignProject($request, $contractor);
    }
}
