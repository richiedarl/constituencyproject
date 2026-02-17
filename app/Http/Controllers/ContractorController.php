<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use App\Services\WalletCreationService;
use Illuminate\Validation\Rule;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContractorController extends Controller
{
    /**
     * Admin: Show contractor details
     */
    protected $walletService;

    public function __construct(WalletCreationService $walletService)
    {
        $this->walletService = $walletService;
    }

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

    public function adminShow(Contractor $contractor)
    {
        try {
            $contractor->load(['user', 'skills', 'applications' => function($query) {
                $query->with('project')->latest();
            }]);

            $stats = [
                'total_applications' => $contractor->applications->count(),
                'approved' => $contractor->applications->where('status', 'approved')->count(),
                'pending' => $contractor->applications->where('status', 'pending')->count(),
                'cancelled' => $contractor->applications->where('status', 'cancelled')->count(),
            ];

            return view('admin.contractors.show', compact('contractor', 'stats'));
        } catch (\Exception $e) {
         return back()
        ->withInput()
        ->withErrors([
            'system' => $e->getMessage()
        ]);
            }
    }

    /**
     * Admin: View contractor's applications
     */
    public function adminApplications(Contractor $contractor)
    {
        try {
            $applications = $contractor->applications()
                ->with('project')
                ->latest()
                ->get();

            return view('admin.contractors.applications', compact('contractor', 'applications'));
        } catch (\Exception $e) {
    return back()
        ->withInput()
        ->withErrors([
            'system' => $e->getMessage()
        ]);
}
    }

    /**
     * Admin: Verify contractor
     */
    public function verify(Contractor $contractor)
    {
        try {
            $contractor->update([
                'verified' => true,
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contractor verified successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to verify contractor.'
            ], 500);
        }
    }

    /**
     * Admin: Suspend contractor
     */
    public function suspend(Request $request, Contractor $contractor)
    {
        try {
            $contractor->update([
                'suspended' => true,
                'suspended_at' => now(),
                'suspended_by' => Auth::id(),
                'suspension_reason' => $request->get('reason', 'Suspended by admin')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contractor suspended successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to suspend contractor.'
            ], 500);
        }
    }

    /**
     * Show contractor's my projects page
     */
    public function myProjects()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login first.');
            }

            if (!$user->contractor) {
                return redirect()->route('contractor.register')
                    ->with('error', 'Please register as a contractor first.');
            }

            // Get all approved applications for this contractor
            $approvedApplications = Application::with(['project' => function($query) {
                    $query->with(['phases.media', 'candidate']);
                }])
                ->where('contractor_id', $user->contractor->id)
                ->where('status', 'approved')
                ->get();

            $projects = $approvedApplications->pluck('project')->filter();

            return view('user.contractors.projects.my-projects', compact('projects'));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load your projects.');
        }
    }

    /**
     * Show a specific project (read-only view for contractors)
     */
    public function showProject(Project $project)
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->contractor) {
                abort(403, 'Access denied.');
            }

            // Verify contractor has approved application for this project
            $hasAccess = Application::where('contractor_id', $user->contractor->id)
                ->where('project_id', $project->id)
                ->where('status', 'approved')
                ->exists();

            if (!$hasAccess) {
                abort(403, 'You do not have access to this project.');
            }

            // Load relationships
            $project->load(['phases.media', 'candidate']);

            return view('user.contractors.projects.show', compact('project'));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load project details.');
        }
    }

    /**
     * Show apply form
     */
    public function showApplyForm(Project $project = null)
    {
        try {
            $user = auth()->user();
            $skills = Skill::all();
            $contractor = null;
            $alreadyApplied = false;

            if ($user) {
                $contractor = Contractor::where('user_id', $user->id)->first();

                if ($contractor && $project) {
                    $alreadyApplied = Application::where('project_id', $project->id)
                        ->where('contractor_id', $contractor->id)
                        ->exists();
                }
            }

            return view('user.contractors.apply', compact(
                'project',
                'contractor',
                'skills',
                'alreadyApplied'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load application form.');
        }
    }

    /**
     * Show create form
     */
    public function create()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login first.');
            }

            if ($user->contractor) {
                return redirect()->route('project.index')
                    ->with('info', 'You are already registered as a contractor.');
            }

            return view('user.contractors.apply');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load registration form.');
        }
    }

    /**
     * Store contractor profile
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('contractors', 'company_name')->ignore(optional(Auth::user()?->contractor)->id)
                ],
                'username' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->ignore(Auth::id())
                ],
                'skills'   => 'nullable|array',
                'skills.*' => 'exists:skills,id',
                'phone' => 'required|string|max:20',
                'experience_years' => 'required|integer|min:0',
                'specialization' => 'required|string|max:255',
                'district' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpg,jpeg,webp,png|max:5048',
                'email' => 'nullable|email',
                'password' => 'nullable|min:6',
                'has_account' => 'required_if:guest,true|in:yes,no',
                'project_id' => 'nullable|exists:projects,id'
            ]);

            // Handle authentication for guests
            if (!Auth::check()) {
                $authResult = $this->handleAuthentication($request);
                if ($authResult instanceof \Illuminate\Http\RedirectResponse) {
                    return $authResult;
                }
            }

            $user = Auth::user();

            // Generate unique slug
            $slug = $this->generateUniqueSlug($user);

            // Handle photo upload
            $photoPath = $this->handlePhotoUpload($request);

            // Create or update contractor
            $contractor = Contractor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $request->company_name,
                    'phone' => $request->phone,
                    'experience_years' => $request->experience_years,
                    'occupation' => $request->specialization,
                    'district' => $request->district,
                    'slug' => $slug,
                    'photo' => $photoPath,
                ]
            );
            // CREATE WALLET FOR THE USER
                // This will create a wallet if it doesn't exist, or return existing one
                $wallet = $this->walletService->ensureWalletExists($user->id);


            $message = $contractor->wasRecentlyCreated
                ? 'Contractor profile created successfully.'
                : 'Contractor profile updated successfully.';

            // Save skills
            if ($request->has('skills')) {
                $contractor->skills()->sync($request->input('skills', []));
            }

            // Handle project application
            if ($request->filled('project_id')) {
                return $this->handleProjectApplication($request, $contractor, $message);
            }

            return redirect()->route('dashboard')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
             return back()
        ->withInput()
        ->withErrors([
            'system' => $e->getMessage()
        ]);
}
    }

    /**
     * Handle authentication for guest users
     */
    private function handleAuthentication(Request $request)
    {
        // Validate has_account is provided for guests
        if (!$request->filled('has_account')) {
            return back()->withErrors([
                'has_account' => 'Please select whether you have an account.'
            ])->withInput();
        }

        // Case 1: User has account - login
        if ($request->has_account === 'yes') {
            if (!$request->filled('email')) {
                return back()->withErrors(['email' => 'Email is required for login.'])->withInput();
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors([
                    'email' => 'No account found. Please select "I don\'t have an account" to register.'
                ])->withInput();
            }

            if (!$request->filled('password')) {
                return back()->withErrors(['password' => 'Password is required.'])->withInput();
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return back()->withErrors(['password' => 'Invalid password.'])->withInput();
            }
        }

        // Case 2: User needs new account - register
        else if ($request->has_account === 'no') {
            if (!$request->filled('email')) {
                return back()->withErrors(['email' => 'Email is required for registration.'])->withInput();
            }

            if (!$request->filled('password')) {
                return back()->withErrors(['password' => 'Password is required for registration.'])->withInput();
            }

            if (User::where('email', $request->email)->exists()) {
                return back()->withErrors([
                    'email' => 'Email already exists. Please login instead.'
                ])->withInput();
            }

            $user = $this->createNewUser($request);
            Auth::login($user);
        }

        return null;
    }

    /**
     * Create a new user
     */
    private function createNewUser(Request $request)
    {
        $username = $request->username ?: Str::before($request->email, '@');
        $baseUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return User::create([
            'name' => $username,
            'email' => $request->email,
            'username' => $username,
            'slug' => Str::slug($username),
            'contractor' => 1,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Generate unique slug for contractor
     */
    private function generateUniqueSlug($user)
    {
        $slugSource = $user->username ?? $user->email;
        $slug = Str::slug($slugSource);
        $baseSlug = $slug;
        $counter = 1;

        while (Contractor::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Handle photo upload
     */
    private function handlePhotoUpload(Request $request)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            return $request->file('photo')->store('contractors', 'public');
        }
        return null;
    }

    /**
     * Handle project application
     */
    private function handleProjectApplication(Request $request, $contractor, $message)
    {
        $alreadyApplied = Application::where('project_id', $request->project_id)
            ->where('contractor_id', $contractor->id)
            ->exists();

        if (!$alreadyApplied) {
            Application::create([
                'project_id' => $request->project_id,
                'contractor_id' => $contractor->id,
                'status' => 'pending'
            ]);

            return redirect()
                ->route('projects.show', $request->project_id)
                ->with('success', 'Application submitted successfully.');
        }

        return redirect()
            ->route('projects.show', $request->project_id)
            ->with('info', 'You have already applied to this project.');
    }
}
