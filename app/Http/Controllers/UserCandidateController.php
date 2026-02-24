<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\ProjectMedia;
use App\Models\Application;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class UserCandidateController extends Controller
{
    /**
     * Show the application form for regular users
     */
    public function create()
{
    $user = auth()->user();

    $candidate = Candidate::where('user_id', $user->id)->first();

    if ($candidate) {
        return redirect()->route('user.candidates.dashboard');
    }

    return view('user.candidates.create');
}


    /**
     * Store the candidate application
     */
public function store(Request $request)
{
    $user = auth()->user();
// Only users without roles can candidates
        if ($user->contributor || $user->contractor || $user->admin) {
            abort(403, 'You are not allowed to become a candidate. Contact admin to change your position to candidate.');
        }
    // Validate the candidate form
    $validated = $request->validate([
        'phone' => 'required|string|max:20',
        'district' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'gender' => 'required|in:male,female,other',
        'bio' => 'nullable|string|max:1000',
        'photo' => 'nullable|image|max:2048',

        // Position info
        'position' => 'required|string|max:255',
        'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
        'year_until' => 'nullable|integer|min:1900|max:' . date('Y'),

        // Paid confirmation
        'paid' => 'required|accepted',
    ]);

    // Handle photo upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('candidates', 'public');
    }

    // Check if candidate exists
    $candidate = Candidate::firstOrCreate(
        ['user_id' => $user->id],
        [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $validated['phone'],
            'district' => $validated['district'],
            'state' => $validated['state'],
            'gender' => $validated['gender'],
            'bio' => $validated['bio'] ?? null,
            'photo' => $photoPath,
            'paid' => true,
        ]
    );

    // Update candidate details if needed (like phone, bio, photo)
    $candidate->update([
        'phone' => $validated['phone'],
        'district' => $validated['district'],
        'state' => $validated['state'],
        'gender' => $validated['gender'],
        'bio' => $validated['bio'] ?? $candidate->bio,
        'photo' => $photoPath ?? $candidate->photo,
        'paid' => true,
    ]);

    // Create candidate wallet if it doesn't exist
    Wallet::firstOrCreate(
        ['user_id' => $user->id],
        ['balance' => 0, 'currency' => 'NGN']
    );

    // Create admin wallet if it doesn't exist
    $adminWallet = Wallet::firstOrCreate(
        ['user_id' => 1], // Admin user
        ['balance' => 0, 'currency' => 'NGN']
    );

    // Determine application fee
    $detail = Detail::latest()->first();
    $applicationFee = $detail && $detail->application_fee ? $detail->application_fee : 1000000;

    // Create the Application if it doesn't already exist
    Application::firstOrCreate(
        ['candidate_id' => $candidate->id],
        ['status' => Application::STATUS_PENDING],
        ['paid' => true,]
    );

    // Create CandidatePosition if not exists
    $candidate->positions()->firstOrCreate(
        ['position' => $validated['position']],
        [
            'year_from' => $validated['year_from'] ?? null,
            'year_until' => $validated['year_until'] ?? null,
            'is_current' => empty($validated['year_until']),
        ]
    );

    // Redirect to project creation form, not dashboard
    return redirect()->route('user.candidates.projects.create', $candidate->id)
                     ->with('success', 'Candidate application submitted successfully! Admin will review it.');
}




public function createProject(Candidate $candidate)
{
    $user = auth()->user();

    // Ensure the candidate belongs to logged-in user
    if ($candidate->user_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Optional: show a warning if there’s already a pending project
    $pendingProject = $candidate->projects()->where('is_active', false)->first();

    if ($pendingProject) {
        return redirect()
            ->route('dashboard')
            ->with('info', 'You already have a pending project. Wait for admin approval before creating another.');
    }

    return view('user.candidates.projects.create', compact('candidate'));
}

public function storeProject(Request $request, Candidate $candidate)
{
    $user = Auth::user();

    // Authorization check
    if ($candidate->user_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Validate project
    $validated = $request->validate([
        'title'             => ['required', 'string', 'max:255'],
        'description'       => ['nullable', 'string'],
        'short_description' => ['nullable', 'string', 'max:255'],
        'type'              => ['nullable', 'string', 'max:100'],
        'state'             => ['required', 'string', 'max:255'],
        'lga'               => ['nullable', 'string', 'max:255'],
        'ward'              => ['nullable', 'string', 'max:255'],
        'community'         => ['nullable', 'string', 'max:255'],
        'address'           => ['nullable', 'string', 'max:255'],
        'start_date'        => ['nullable', 'date'],
        'completion_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
        'estimated_budget'  => ['nullable', 'numeric'],
        'featured_image'    => ['nullable', 'image', 'max:2048']
    ]);

    // Handle featured image
    if ($request->hasFile('featured_image')) {
        $validated['featured_image'] = $request->file('featured_image')
            ->store('projects/images', 'public');
    }

    // Create Project
    $project = $candidate->projects()->create(array_merge($validated, [
        'is_active' => false, // starts inactive
    ]));

    // Create pending Application
    $application = Application::create([
        'candidate_id' => $candidate->id,
        'project_id'   => $project->id,
        'status'       => Application::STATUS_PENDING,
    ]);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Project created and pending admin approval.');
}
}
