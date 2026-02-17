<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\ProjectMedia;
use App\Models\Application;
use App\Models\User;
use App\Models\Wallet;
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
        return view('user.candidates.create');
    }

    /**
     * Store the candidate application
     */
    public function store(Request $request)
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->handleAuthenticatedUser($request);
        }

        // Handle based on user type selection
        if ($request->has('user_type')) {
            if ($request->user_type === 'registered') {
                return $this->handleRegisteredUser($request);
            } else {
                return $this->handleNewUser($request);
            }
        }

        // If no user_type selected, show form with error
        return back()->with('error', 'Please select whether you have an existing account.');
    }

    /**
     * Handle authenticated user
     */
    private function handleAuthenticatedUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'required|string|max:20',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'paid' => 'required|accepted',
            'position' => 'required|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_until' => 'nullable|integer|min:1900|max:' . date('Y'),
            'photo' => 'nullable|image|max:2048',
        ]);

        // Check for existing candidate
        $existingCandidate = Candidate::where('email', $validated['email'])
            ->orWhere('phone', $validated['phone'])
            ->first();

        if ($existingCandidate) {
            return back()->with('error', 'A candidate with this email or phone already exists.');
        }

        return $this->createCandidate($request, $validated, Auth::user());
    }

    /**
     * Handle registered user (not logged in)
     */
    private function handleRegisteredUser(Request $request)
    {
        $request->validate([
            'login_email' => 'required|email',
            'login_password' => 'required|string',
        ]);

        // Attempt to find user
        $user = User::where('email', $request->login_email)->first();

        if (!$user || !Hash::check($request->login_password, $user->password)) {
            return back()->withInput()
                ->with('error', 'Invalid email or password.')
                ->with('show_login', true);
        }

        // Check if user already has a candidate profile
        $existingCandidate = Candidate::where('user_id', $user->id)->first();
        if ($existingCandidate) {
            return back()->with('error', 'You already have a candidate profile. Please login and visit your dashboard.');
        }

        // Log the user in
        Auth::login($user);

        // Validate the rest of the form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'required|string|max:20',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'paid' => 'required|accepted',
            'position' => 'required|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_until' => 'nullable|integer|min:1900|max:' . date('Y'),
            'photo' => 'nullable|image|max:2048',
        ]);

        return $this->createCandidate($request, $validated, $user);
    }

    /**
     * Handle new user (create account)
     */
    private function handleNewUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:candidates,phone',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'paid' => 'required|accepted',
            'position' => 'required|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_until' => 'nullable|integer|min:1900|max:' . date('Y'),
            'photo' => 'nullable|image|max:2048',
        ]);

        // Check for existing candidate by email or phone
        $existingCandidate = Candidate::where('email', $validated['email'])
            ->orWhere('phone', $validated['phone'])
            ->first();

        if ($existingCandidate) {
            return back()->with('error', 'A candidate with this email or phone already exists. Please use the "Registered User" option.');
        }

        // Generate unique username
        $firstName = explode(' ', trim($validated['name']))[0];
        $baseUsername = strtolower($firstName);
        $count = User::where('username', 'like', $baseUsername . '%')->count();
        $username = $count ? $baseUsername . ($count + 1) : $baseUsername;

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $username,
            'password' => Hash::make($validated['password']),
        ]);

        // Log the user in
        Auth::login($user);

        return $this->createCandidate($request, $validated, $user);
    }

    /**
     * Create candidate record
     */
    private function createCandidate(Request $request, array $validated, User $user)
    {
        try {
            return DB::transaction(function () use ($request, $validated, $user) {

                // Handle photo upload
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')->store('candidates', 'public');
                }

                // Generate unique slug
                $baseSlug = Str::slug($validated['name']);
                $slugCount = Candidate::where('slug', 'like', $baseSlug . '%')->count();
                $slug = $slugCount ? $baseSlug . '-' . ($slugCount + 1) : $baseSlug;

                // Create candidate
                $candidate = Candidate::create([
                    'name' => $validated['name'],
                    'slug' => $slug,
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'district' => $validated['district'],
                    'state' => $validated['state'],
                    'gender' => $validated['gender'],
                    'bio' => $validated['bio'] ?? null,
                    'paid' => true,
                    'photo' => $photoPath,
                    'user_id' => $user->id,
                ]);

                // Create wallet
                Wallet::create([
                    'user_id' => $user->id,
                    'candidate_id' => $candidate->id,
                    'balance' => 0,
                    'currency' => 'NGN',
                ]);

                // Create current position
                $candidate->positions()->create([
                    'position' => $validated['position'],
                    'year_from' => $validated['year_from'] ?? null,
                    'year_until' => $validated['year_until'] ?? null,
                    'is_current' => true,
                ]);

                return redirect()->route('user.candidates.projects.create', $candidate->id)
                    ->with('success', 'Profile created successfully! Now tell us about your project.');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred. Please try again.');
        }
    }


    /**
     * Show edit form
     */
    public function edit($id)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($id);
        return view('user.candidates.edit', compact('candidate'));
    }

    /**
     * Update candidate
     */
    public function update(Request $request, $id)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $validated['photo'] = $request->file('photo')->store('candidates/photos', 'public');
        }

        $candidate->update($validated);

        return redirect()->route('user.candidates.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show candidate dashboard
     */
    public function dashboard()
    {
        $candidate = Candidate::where('user_id', Auth::id())->first();

        if (!$candidate) {
            return redirect()->route('user.candidates.create');
        }

        $projects = Project::where('candidate_id', $candidate->id)
                          ->with('phases')
                          ->latest()
                          ->get();

        $applications = Application::where('candidate_id', $candidate->id)
                        ->with('project')
                        ->latest()
                        ->get();

        return view('user.candidates.dashboard', compact('candidate', 'projects', 'applications'));
    }

    /**
     * Show the project creation form
     */
    public function createProject($candidateId)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($candidateId);
        return view('user.candidates.projects.create', compact('candidate'));
    }

    /**
     * Store the project
     */
    public function storeProject(Request $request, $candidateId)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($candidateId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:200',
            'state' => 'required|string|max:100',
            'lga' => 'required|string|max:100',
            'ward' => 'nullable|string|max:100',
            'community' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'estimated_budget' => 'required|numeric|min:0',
            'start_date' => 'required|date|after:today',
            'completion_date' => 'nullable|date|after:start_date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['candidate_id'] = $candidate->id;
        $validated['status'] = 'planning';
        $validated['is_active'] = true;
        $validated['is_public'] = true;

        $project = Project::create($validated);

        return redirect()->route('user.candidates.projects.phases.create', [$candidate->id, $project->id])
            ->with('success', 'Project created! Now add project phases.');
    }

    /**
     * Show the phase creation form
     */
    public function createPhase($candidateId, $projectId)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($candidateId);
        $project = Project::where('candidate_id', $candidateId)
                         ->findOrFail($projectId);

        return view('user.candidates.projects.phases.create', compact('candidate', 'project'));
    }

    /**
     * Store project phases
     */
    public function storePhase(Request $request, $candidateId, $projectId)
    {
        $candidate = Candidate::where('user_id', Auth::id())->findOrFail($candidateId);
        $project = Project::where('candidate_id', $candidateId)
                         ->findOrFail($projectId);

        $validated = $request->validate([
            'phases' => 'required|array|min:1',
            'phases.*.phase' => 'required|in:planning,executing,documenting,completed',
            'phases.*.description' => 'required|string|max:500',
            'phases.*.status' => 'required|string|max:100',
            'phases.*.started_at' => 'required|date',
            'phases.*.ended_at' => 'nullable|date|after:phases.*.started_at',
            'phases.*.media' => 'nullable|array',
            'phases.*.media.*' => 'nullable|image|max:5120',
        ]);

        foreach ($validated['phases'] as $phaseData) {
            $phase = ProjectPhase::create([
                'project_id' => $project->id,
                'phase' => $phaseData['phase'],
                'description' => $phaseData['description'],
                'status' => $phaseData['status'],
                'started_at' => $phaseData['started_at'],
                'ended_at' => $phaseData['ended_at'] ?? null,
            ]);

            if (isset($phaseData['media'])) {
                foreach ($phaseData['media'] as $mediaFile) {
                    if ($mediaFile && $mediaFile->isValid()) {
                        $path = $mediaFile->store('projects/media', 'public');

                        ProjectMedia::create([
                            'project_phase_id' => $phase->id,
                            'file_path' => $path,
                            'file_type' => $mediaFile->getClientMimeType(),
                        ]);
                    }
                }
            }
        }

        Application::create([
            'candidate_id' => $candidate->id,
            'project_id' => $project->id,
            'status' => 'pending',
        ]);

        return redirect()->route('user.candidates.dashboard')
            ->with('success', 'Your application has been submitted for review!');
    }
}
