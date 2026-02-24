<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\ProjectPhase;
use DB;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function active()
    {
        $user = Auth::user();
        $projects = collect();

        $contractorProjects = collect();
        $contributorProjects = collect();

        // Get projects where user is an approved contractor
        if ($user->contractor) {
            $contractorProjects = Project::with(['candidate', 'phases' => function($query) {
                    $query->with('media')->orderBy('started_at');
                }])
                ->where('is_active', true)
                ->whereIn('id', function($query) use ($user) {
                    $query->select('project_id')
                        ->from('applications')
                        ->where('contractor_id', $user->contractor->id)
                        ->where('status', 'approved');
                })
                ->get()
                ->each(function($project) {
                    $project->user_role = 'contractor';
                    $project->involvement_date = $project->applications()
                        ->where('contractor_id', Auth::user()->contractor->id)
                        ->where('status', 'approved')
                        ->first()
                        ->created_at ?? $project->created_at;
                });
        }

        // Get projects where user is a contributor (has made donations)
        if ($user->contributor) {
            $contributorProjects = Project::with(['candidate', 'phases' => function($query) {
                    $query->with('media')->orderBy('started_at');
                }])
                ->where('is_active', true)
                ->whereIn('id', function($query) use ($user) {
                    $query->select('project_id')
                        ->from('donations')
                        ->where('contributor_id', $user->contributor->id);
                })
                ->get()
                ->each(function($project) use ($user) {
                    $project->user_role = 'contributor';
                    $project->total_donated = Donation::where('contributor_id', $user->contributor->id)
                        ->where('project_id', $project->id)
                        ->sum('amount');
                    $project->involvement_date = Donation::where('contributor_id', $user->contributor->id)
                        ->where('project_id', $project->id)
                        ->first()
                        ->created_at ?? $project->created_at;
                });
        }

        // Merge and sort by involvement date
        $projects = $contractorProjects->concat($contributorProjects)
            ->sortByDesc('involvement_date');

        // Get counts for stats
        $stats = [
            'total_projects' => $projects->count(),
            'contractor_projects' => $contractorProjects->count(),
            'contributor_projects' => $contributorProjects->count(),
            'total_donated' => $contributorProjects->sum('total_donated'),
        ];

        return view('user.projects.active', compact('projects', 'stats'));
    }

    /**
     * Display active projects for admin
     * Active projects are those with status 'ongoing' and is_active = true
     */
    public function adminActive()
    {
        $projects = Project::with(['candidate', 'phases'])
            ->where('is_active', true)
            // ->where('status', 'ongoing')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.projects.active', compact('projects'));
    }

    public function index()
    {
        $projects = Project::all();

        if ($projects->count() > 0) {
            return view('admin.projects.index', [
                'projects' => $projects
            ]);
        } else {
            // If no projects, you can either return the same view with an empty collection
            // or return a different view / message
            return redirect()->route('dashboard')->with('message', 'No projects found.');
        }
    }

public function userIndex()
{
    $user = auth()->user();

    // Determine user role
    $role = null;
    if ($user) {
        if ($user->candidate) {
            $role = 'candidate';
        } elseif ($user->contractor) {
            $role = 'contractor';
        } elseif ($user->contributor) {
            $role = 'contributor';
        }
    }

    // Start with base query for all active/public projects
    $projects = Project::with(['candidate', 'phases'])
        ->active()
        ->public()
        ->latest()
        ->get();

    // Add user-specific data if logged in
    if ($user) {
        foreach ($projects as $project) {
            // Default flags
            $project->is_owner = false;
            $project->can_edit = false;
            $project->can_apply = false;
            $project->can_sponsor = false;
            $project->user_applied = false;

            // Check if user is the project owner (candidate)
            if ($user->candidate && $project->candidate_id === $user->candidate->id) {
                $project->is_owner = true;
                $project->can_edit = ($project->status !== 'approved');
            }

            // Check if user applied as contractor
            if ($user->contractor) {
                $application = Application::where('contractor_id', $user->contractor->id)
                    ->where('project_id', $project->id)
                    ->first();

                if ($application) {
                    $project->user_applied = true;
                    $project->user_application_status = $application->status;
                    $project->user_application_id = $application->id;
                } else {
                    $project->can_apply = true;
                }
            }

            // Check if user is a contributor
            if ($user->contributor) {
                $project->can_sponsor = true;
            }
        }
    }

    return view('user.projects.index', compact('projects', 'role'));
}

public function userMine()
{
    $user = auth()->user();

    // Candidate → projects they created
    if ($user->candidate) {

        $projects = Project::where('candidate_id', $user->candidate->id)
            ->latest()
            ->get();

        return view('user.projects.mine', compact('projects'));
    }

    // Contributor → projects they sponsored
    if ($user->contributor) {

        $projects = Project::whereHas('donations', function ($query) use ($user) {
            $query->where('contributor_id', $user->id);
        })
        ->with('donations')
        ->latest()
        ->get();

        return view('user.projects.mine', compact('projects'));
    }

    abort(403);
}

public function userPast()
{
    $user = auth()->user();

    if ($user->candidate) {
        $projects = Project::where('user_id', $user->id)
            ->whereIn('status', ['rejected', 'cancelled'])
            ->latest()
            ->get();
    }

    if ($user->contributor) {
        $projects = Project::whereHas('donations', function ($q) use ($user) {
                $q->where('contributor_id', $user->id);
            })
            ->whereIn('status', ['rejected', 'cancelled'])
            ->latest()
            ->get();
    }

    return view('user.projects.past', compact('projects'));
}

public function userCompleted()
{
    $user = auth()->user();

    if ($user->candidate) {
        $projects = Project::where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->get();
    }

    if ($user->contributor) {
        $projects = Project::whereHas('donations', function ($q) use ($user) {
                $q->where('contributor_id', $user->id);
            })
            ->where('status', 'completed')
            ->latest()
            ->get();
    }

    return view('user.projects.completed', compact('projects'));
}

public function userShow(Project $project)
{
    $user = auth()->user();

    // Authorization check
    $isOwner = $project->candidate_id === $user->id;
    $isSponsor = $project->donations()
        ->where('contributor_id', $user->id)
        ->exists();

    if (!$isOwner && !$isSponsor) {
        abort(403, 'Unauthorized access to this project.');
    }

    // Eager-load only what the accessors will use
    $project->load([
        'phases.media',
        'candidate',
    ]);

    return view('user.projects.show', compact('project'));
}



public function edit(Project $project)
{
    // Eager-load relationships needed for editing
    $project->load([
        'candidate.user',
        'phases' => fn ($q) => $q->orderBy('started_at'),
    ]);

    return view('admin.projects.edit', compact('project'));
}

public function update(Request $request, Project $project)
{
    $validated = $request->validate([
        'title'               => 'required|string|max:255',
        'short_description'   => 'nullable|string',
        'description'         => 'nullable|string',
        'type'                => 'required|in:executing,documenting',
        'status'              => 'required|string',
        'start_date'          => 'nullable|date',
        'completion_date'     => 'nullable|date|after_or_equal:start_date',
        'estimated_budget'    => 'nullable|numeric|min:0',
        'actual_cost'         => 'nullable|numeric|min:0',
        'featured_image'      => 'nullable|image|max:5120',
        'media.*'             => 'nullable|file|
                                  mimetypes:image/jpeg,image/png,image/webp,
                                  video/mp4|max:20480',
        'is_public'           => 'boolean',
        'is_active'           => 'boolean',
    ]);

    DB::beginTransaction();

    try {

        /**
         * 1️⃣ Handle Featured Image Replacement
         */
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] =
                $request->file('featured_image')
                        ->store('projects/featured', 'public');
        }

        /**
         * 2️⃣ Update Project Core Fields
         */
        $project->update($validated);

        /**
         * 3️⃣ Attach New Media to CURRENT PHASE
         */
        if ($request->hasFile('media')) {

            $phase = $project->current_phase;

            if ($phase) {
                foreach ($request->file('media') as $file) {

                    $path = $file->store('projects/media', 'public');

                    ProjectMedia::create([
                        'project_phase_id' => $phase->id,
                        'file_path'        => $path,
                        'file_type'        => str_starts_with($file->getMimeType(), 'video')
                                                ? 'video'
                                                : 'image',
                    ]);
                }
            }
        }

        DB::commit();

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();

        return back()
            ->withErrors('Failed to update project: ' . $e->getMessage())
            ->withInput();
    }
}

    // Show media page for a single phase
    public function mediaPhasePage(ProjectPhase $phase)
    {
        $project = $phase->project;
        $media = $phase->media()->latest()->get(); // assumes Phase has media() relation
        return view('admin.projects.phaseMedia', compact('phase', 'project', 'media'));
    }

    public function changePhase(Request $request, Project $project)
    {
        $validated = $request->validate([
            'phase' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);
            // dd($request->project_id);
        DB::transaction(function () use ($project, $validated) {

            // 1️⃣ Close current phase
            $currentPhase = $project->phases()
                ->whereNull('ended_at')
                ->latest()
                ->first();

            if ($currentPhase) {
                $currentPhase->update([
                    'ended_at' => now(),
                ]);
            }

            // 2️⃣ Create new phase
            ProjectPhase::create([
                'project_id'  => $project->id,
                'phase'       => $validated['phase'],
                'status'      => $validated['status'],
                'description' => $validated['description'] ?? null,
                'weight'      => 10, // or configurable later
                'started_at'  => now(),
            ]);

        });

        return back()->with('success', 'Project phase updated successfully.');
    }


    /**
     * Add media to a specific project phase
     */
    public function addMediaToPhase(Request $request)
    {
        $request->validate([
            'phase_id' => 'required|exists:project_phases,id',
            'media'    => 'required|array|min:1',
            'media.*'  => 'file|max:20480|mimes:jpg,jpeg,png,gif,bmp,svg,webp,mp4,mov,avi,wmv,flv,mpg,mpeg',
        ]);

        // Remove empty file inputs
        $files = collect($request->file('media'))
            ->filter()
            ->values();

        if ($files->isEmpty()) {
            return back()->withErrors([
                'media' => 'Please select at least one valid file.',
            ]);
        }

        // Validate each REAL file
        foreach ($files as $file) {
            validator(
                ['file' => $file],
                ['file' => 'file|max:20480|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime,video/x-msvideo']
            )->validate();
        }

        $phase = ProjectPhase::findOrFail($request->phase_id);

        DB::transaction(function () use ($files, $phase) {
            foreach ($files as $file) {
                $path = $file->store('projects/media', 'public');

                ProjectMedia::create([
                    'project_phase_id' => $phase->id,
                    'file_path'        => $path,
                    'file_type'        => str_starts_with($file->getMimeType(), 'video')
                        ? 'video'
                        : 'image',
                ]);
            }
        });

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function show(Project $project)
    {
        // Eager-load only what the accessors will use
        $project->load([
            'phases.media',
            'candidate',
        ]);

        return view('admin.projects.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show create project form
     * Also handles optional CSV upload for prefilling
     */
    public function create(Request $request)
    {
        $csvData = [];

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');

            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                $headers = fgetcsv($handle, 1000, ',');

                if ($headers) {
                    $row = fgetcsv($handle, 1000, ',');

                    if ($row) {
                        foreach ($headers as $index => $header) {
                            $key = strtolower(trim($header));
                            $csvData[$key] = $row[$index] ?? null;
                        }
                    }
                }

                fclose($handle);
            }
        }

        return view('admin.projects.create', [
            'candidates' => Candidate::orderBy('name')->get(),
            'csvData'    => $csvData,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'candidate_id'       => 'required|exists:candidates,id',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'status'             => 'nullable|string',
            'project_mode'       => 'required|in:executing,documenting',
            'type'       => 'required|in:executing,documenting',
            'start_date'         => 'nullable|date',
            'completion_date'    => 'nullable|date',
            'state'              => 'nullable|string',
            'lga'                => 'nullable|string',
            'community'          => 'nullable|string',
            'address'            => 'nullable|string',
            'estimated_budget'   => 'nullable|numeric',
            'actual_cost'   => 'nullable|numeric',
            'featured_image'     => 'nullable|image|max:5120',
            'media.*'            => 'nullable|file|
                                    mimetypes:image/jpeg,image/png,image/webp,
                                    video/mp4|max:20480',

        ]);

        DB::beginTransaction();

        try {
            /**
             * 1️⃣ Handle Featured Image
             */
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] =
                    $request->file('featured_image')
                            ->store('projects/featured', 'public');
            }

            /**
             * 2️⃣ Extract Project Mode (NOT stored on projects table)
             */
            $projectMode = $validated['project_mode'];
            unset($validated['project_mode']);

            $status = $validated['status'];
            unset($validated['status']);

            $type = $validated['type'];
            unset($validated['type']);

            /**
             * 3️⃣ Create Project
             */
            $project = Project::create($validated);
            $project->update([
                'type' => $type
            ]);
            /**
             * 4️⃣ Create Initial Phase
             */
            $initialPhase = ProjectPhase::create([
                'project_id' => $project->id,
                'phase'      => $projectMode, // executing | documenting
                'status' => $status,
                'weight' => 10,
                'started_at' => now(),
            ]);

            /**
             * 5️⃣ Attach Media to Phase
             */
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {

                    $path = $file->store('projects/media', 'public');

                    ProjectMedia::create([
                        'project_phase_id' => $initialPhase->id,
                        'file_path'        => $path,
                        'file_type'        => str_starts_with($file->getMimeType(), 'video')
                                                ? 'video'
                                                : 'image',
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            // Temporarily show the real error to debug
            return back()
                ->withErrors('Failed to create project: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deletePhaseMedia(ProjectMedia $media)
    {
        $phaseId = $media->project_phase_id;

        $media->delete();

        return back()->with('success', 'Media deleted successfully.');
    }

    public function contractorUploadMedia(Request $request, Project $project)
{
    $user = auth()->user();

    if (!$user->contractor) {
        abort(403);
    }

    $latestPhase = $project->current_phase;

    if (!$latestPhase) {
        return back()->with('error', 'No active phase found.');
    }

    $request->validate([
        'media.*' => 'required|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120'
    ]);

    foreach ($request->file('media') as $file) {

        $path = $file->store('project_media', 'public');

        ProjectMedia::create([
            'project_phase_id' => $latestPhase->id,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
        ]);
    }

    return back()->with('success', 'Media uploaded successfully.');
}
}
