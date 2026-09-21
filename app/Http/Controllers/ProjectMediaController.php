<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhase;
use App\Models\ProjectMedia;
use App\Models\Application;
use Illuminate\Http\Request;

class ProjectMediaController extends Controller
{
    /**
     * Store media uploaded by a contractor against a project phase.
     */
    public function store(Request $request, ProjectPhase $phase)
    {
        $user = auth()->user();

        if (!$user->contractor) {
            abort(403);
        }

        $hasAccess = Application::where('contractor_id', $user->contractor->id)
            ->where('project_id', $phase->project_id)
            ->where('status', Application::STATUS_APPROVED)
            ->exists();

        if (! $hasAccess) {
            abort(403, 'You are not assigned to this project.');
        }

        $request->validate([
            'media'   => 'required|array|min:1',
            'media.*' => 'file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
        ]);

        foreach ($request->file('media') as $file) {
            $path = $file->store('project_media', 'public');

            ProjectMedia::create([
                'project_phase_id' => $phase->id,
                'file_path'        => $path,
                'file_type'        => str_starts_with($file->getMimeType(), 'image/')
                    ? 'image'
                    : (str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'document'),
                'uploaded_by'      => $user->id,
            ]);
        }

        return back()->with('success', 'Media uploaded successfully.');
    }
}
