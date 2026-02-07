<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\ProjectPhase;
use DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

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
        'phase'  => 'required|in:executing,documenting',
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
            'project_id' => $project->id,
            'phase'      => $validated['phase'],
            'status'     => $validated['status'],
            'description' => $validated['description'] ?? null,
            'started_at' => now(),
        ]);
    });

    return back()->with('success', 'Project phase updated successfully.');
}


    /**
     * Add media to a specific project phase
     */
public function addMediaToPhase(Request $request)
{
//     dd(
//     ini_get('upload_max_filesize'),
//     ini_get('post_max_size'),
//     count($request->file('media')),
//     array_filter($request->file('media'))
// );

    $request->validate([
        'phase_id' => 'required|exists:project_phases,id',
        'media'    => 'required|array|min:1',
        'media.*'  => 'nullable|file|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime,video/x-msvideo|max:20480',
    ]);

    $phase = ProjectPhase::findOrFail($request->phase_id);

    // 🔑 Filter out empty inputs
    $files = array_filter($request->file('media'));

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
        'start_date'         => 'nullable|date',
        'completion_date'    => 'nullable|date',
        'state'              => 'nullable|string',
        'lga'                => 'nullable|string',
        'community'          => 'nullable|string',
        'address'            => 'nullable|string',
        'estimated_budget'   => 'nullable|numeric',
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

        /**
         * 3️⃣ Create Project
         */
        $project = Project::create($validated);

        /**
         * 4️⃣ Create Initial Phase
         */
        $initialPhase = ProjectPhase::create([
            'project_id' => $project->id,
            'phase'      => $projectMode, // executing | documenting
            'status' => $status,
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

}
