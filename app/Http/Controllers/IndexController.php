<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Application;
use App\Models\Contractor;
use App\Models\Candidate;
use App\Models\Contributor;
use App\Models\Donation;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class IndexController extends Controller
{
    /**
     * Dashboard for authenticated users
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to access the dashboard');
        }

        $user = Auth::user();
        $data = [];

        // Get wallet balance for ALL users - FIXED: wallet belongs to user, not contributor
        $wallet = Wallet::where('user_id', $user->id)->first();
        $data['walletBalance'] = $wallet ? $wallet->balance : 0;

        // Common data for all users
        $data['recentProjects'] = Project::with(['candidate', 'phases'])
            ->latest()
            ->take(5)
            ->get();

        // Add candidates for all users (for the modal)
        $data['candidates'] = Candidate::where('approved', true)
            ->orderBy('name')
            ->get();

        // Admin specific data
        if ($user->admin) {
            $data['totalProjects'] = Project::count();
            $data['ongoingProjects'] = Project::ongoing()->count();
            $data['completedProjects'] = Project::completed()->count();
            $data['totalCandidates'] = Candidate::count();
            $data['totalApplications'] = Application::count();
            $data['todaysApplications'] = Application::whereDate('created_at', Carbon::today())->count();
            $data['totalWallets'] = Wallet::sum('balance');
            $data['todaysEarnings'] = Application::whereDate('created_at', Carbon::today())
                ->where('status', 'approved')
                ->sum('amount_deposited');
            $data['pendingApplications'] = Application::where('status', 'pending')->count();
            $data['totalContractors'] = Contractor::count();
            $data['totalContributors'] = Contributor::count();
        }

        // Contractor specific data
        if ($user->contractor) {
            // Get the contractor record associated with this user
            $contractor = Contractor::where('user_id', $user->id)->first();

            if ($contractor) {
                $contractorId = $contractor->id;

                // My Total Contracts (approved applications)
                $data['myTotalContracts'] = Application::where('contractor_id', $contractorId)
                    ->where('status', 'approved')
                    ->count();

                // Pending Applications (applications pending approval)
                $data['pendingApplications'] = Application::where('contractor_id', $contractorId)
                    ->where('status', 'pending')
                    ->count();

                // Active/Ongoing Projects (approved applications with ongoing projects)
                $data['activeProjects'] = Project::whereIn('id', function($query) use ($contractorId) {
                    $query->select('project_id')
                        ->from('applications')
                        ->where('contractor_id', $contractorId)
                        ->where('status', 'approved');
                })
                ->where('status', 'ongoing')
                ->where('is_active', true)
                ->with(['candidate'])
                ->get();

                $data['activeProjectsCount'] = $data['activeProjects']->count();

                // Past Contracts (completed projects)
                $data['pastProjects'] = Project::whereIn('id', function($query) use ($contractorId) {
                    $query->select('project_id')
                        ->from('applications')
                        ->where('contractor_id', $contractorId)
                        ->where('status', 'approved');
                })
                ->where('status', 'completed')
                ->with(['candidate'])
                ->get();

                $data['pastProjectsCount'] = $data['pastProjects']->count();

                // Total earnings from all completed projects
                $data['totalEarnings'] = Application::where('contractor_id', $contractorId)
                    ->where('status', 'approved')
                    ->whereHas('project', function($query) {
                        $query->where('status', 'completed');
                    })
                    ->sum('amount_deposited') ?? 0;
            } else {
                // Set default values if no contractor record exists
                $data['myTotalContracts'] = 0;
                $data['pendingApplications'] = 0;
                $data['activeProjects'] = collect([]);
                $data['activeProjectsCount'] = 0;
                $data['pastProjects'] = collect([]);
                $data['pastProjectsCount'] = 0;
                $data['totalEarnings'] = 0;
            }
        }

        // Contributor specific data
        if ($user->contributor) {
            // Get the contributor record associated with this user
            $contributor = Contributor::where('user_id', $user->id)->first();

            if ($contributor) {
                $contributorId = $contributor->id;

                // My Total Contributions (approved donations)
                $data['myTotalContributions'] = Donation::where('contributor_id', $contributorId)
                    ->where('approved', true)
                    ->count();

                // Total Amount Donated
                $data['totalAmountDonated'] = Donation::where('contributor_id', $contributorId)
                    ->where('approved', true)
                    ->sum('amount') ?? 0;

                // Pending Contributions
                $data['pendingContributions'] = Donation::where('contributor_id', $contributorId)
                    ->where('approved', false)
                    ->count();

                // Projects I've Supported
                $data['supportedProjects'] = Project::whereIn('id', function($query) use ($contributorId) {
                    $query->select('project_id')
                        ->from('donations')
                        ->where('contributor_id', $contributorId)
                        ->where('approved', true);
                })
                ->with(['candidate'])
                ->get();

                $data['supportedProjectsCount'] = $data['supportedProjects']->count();

                // Active Projects Available to Support
                $data['activeProjects'] = Project::where('is_active', true)
                    ->where('status', 'ongoing')
                    ->where('is_public', true)
                    ->with(['candidate'])
                    ->get();

                $data['activeProjectsCount'] = $data['activeProjects']->count();

                // Active Candidates (this is already set above, but we'll keep it for clarity)
                $data['activeCandidates'] = Candidate::where('approved', true)
                    ->orderBy('name')
                    ->get();
            } else {
                // Set default values if no contributor record exists
                $data['myTotalContributions'] = 0;
                $data['totalAmountDonated'] = 0;
                $data['pendingContributions'] = 0;
                $data['supportedProjects'] = collect([]);
                $data['supportedProjectsCount'] = 0;
                $data['activeProjects'] = Project::where('is_active', true)
                    ->where('status', 'ongoing')
                    ->where('is_public', true)
                    ->with(['candidate'])
                    ->get();
                $data['activeProjectsCount'] = $data['activeProjects']->count();
                $data['activeCandidates'] = Candidate::where('approved', true)
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('dashboard', $data);
    }

/**
 * Public homepage with projects and contributors
 */
public function home()
{
    $projects = Project::active()
        ->public()
        ->with(['candidate', 'phases'])
        ->inRandomOrder()
        ->paginate(9);

    // Fix: Get top contributors based on approved donations only
    $topContributors = Contributor::with(['user'])
        ->withSum(['donations' => function($query) {
            $query->where('approved', true);
        }], 'amount')
        ->having('donations_sum_amount', '>', 0) // Only those with donations
        ->orderByDesc('donations_sum_amount')
        ->take(10)
        ->get();

    // If no contributors with approved donations, get all and calculate manually
    if ($topContributors->isEmpty()) {
        $allContributors = Contributor::with(['user', 'donations' => function($query) {
            $query->where('approved', true);
        }])->get();

        $topContributors = $allContributors->map(function($contributor) {
            $contributor->donations_sum_amount = $contributor->donations->sum('amount');
            return $contributor;
        })
        ->filter(function($contributor) {
            return $contributor->donations_sum_amount > 0;
        })
        ->sortByDesc('donations_sum_amount')
        ->take(10)
        ->values();
    }

    $candidates = Candidate::where('approved', true)
        ->take(6)
        ->get();

    // Featured portfolios - candidates with most projects
    $featuredPortfolios = Candidate::where('approved', true)
        ->with(['projects', 'projects.phases', 'positions'])
        ->withCount('projects')
        ->orderByDesc('projects_count')
        ->take(6)
        ->get();

    // For each portfolio, calculate total updates across all phases
    foreach ($featuredPortfolios as $portfolio) {
        $totalUpdates = 0;
        foreach ($portfolio->projects as $project) {
            foreach ($project->phases as $phase) {
                $totalUpdates += $phase->updates()->count();
            }
        }
        $portfolio->total_updates = $totalUpdates;
    }

    // Featured personalities for the detailed view
    $featuredCandidates = Candidate::where('approved', true)
        ->with(['projects', 'projects.phases', 'positions'])
        ->withCount('projects')
        ->orderByDesc('projects_count')
        ->take(5)
        ->get();

    // Calculate updates for featured candidates too
    foreach ($featuredCandidates as $candidate) {
        $totalUpdates = 0;
        foreach ($candidate->projects as $project) {
            foreach ($project->phases as $phase) {
                $totalUpdates += $phase->updates()->count();
            }
        }
        $candidate->total_updates = $totalUpdates;
    }

    // Debug: Check the top contributors data
    // \Log::info('Top Contributors', ['data' => $topContributors->toArray()]);

    return view('index', compact(
        'projects',
        'topContributors',
        'candidates',
        'featuredPortfolios',
        'featuredCandidates'
    ));
}
    /**
     * Display list of all contributors
     */
    public function contributors()
    {
        $contributors = Contributor::with(['user', 'donations'])
            ->withSum('donations', 'amount')
            ->orderByDesc('donations_sum_amount')
            ->paginate(12);

        return view('user.contributors.index', compact('contributors'));
    }

    /**
     * Display a single contributor's profile
     */
/**
 * Display a single contributor's profile
 */
public function contributorProfile($slug = null, $id = null)
{
    // Find contributor by slug or ID
    $query = Contributor::with(['user', 'donations.project']);

    if ($id) {
        $contributor = $query->findOrFail($id);
    } elseif ($slug) {
        $contributor = $query->where('slug', $slug)->firstOrFail();
    } else {
        abort(404);
    }

    // Get contributor's donation statistics
    $totalDonated = $contributor->donations()->where('approved', true)->sum('amount');
    $donationCount = $contributor->donations()->where('approved', true)->count();

    // Get projects they've supported
    $supportedProjects = Project::whereIn('id',
        $contributor->donations()->where('approved', true)->pluck('project_id')->unique()
    )->with(['candidate'])->take(6)->get();

    // Get recent donations
    $recentDonations = $contributor->donations()
        ->with('project')
        ->where('approved', true)
        ->latest()
        ->take(10)
        ->get();

    // Get contribution rank
    $allContributors = Contributor::withSum('donations', 'amount')->get();
    $rank = 1;
    foreach ($allContributors as $c) {
        if (($c->donations_sum_amount ?? 0) > $totalDonated) {
            $rank++;
        }
    }

    // Determine contributor tier
    $tierData = $this->getContributorTier($totalDonated);

    // Extract tier variables for the view
    $tierName = $tierData['name'];
    $tierColor = $tierData['color'];
    $tierIcon = $tierData['icon'];
    $tierLevel = $tierData['badge'];

    return view('user.contributors.profile', compact(
        'contributor',
        'totalDonated',
        'donationCount',
        'supportedProjects',
        'recentDonations',
        'rank',
        'tierName',
        'tierColor',
        'tierIcon',
        'tierLevel'
    ));
}
    /**
     * Determine contributor tier based on total donations
     */
    private function getContributorTier($totalDonated)
    {
        if ($totalDonated >= 1000000) {
            return [
                'name' => 'Platinum Patron',
                'color' => 'warning',
                'icon' => 'bi-stars',
                'badge' => 'platinum'
            ];
        } elseif ($totalDonated >= 500000) {
            return [
                'name' => 'Gold Supporter',
                'color' => 'secondary',
                'icon' => 'bi-gem',
                'badge' => 'gold'
            ];
        } elseif ($totalDonated >= 100000) {
            return [
                'name' => 'Silver Contributor',
                'color' => 'bronze',
                'icon' => 'bi-award',
                'badge' => 'silver'
            ];
        } else {
            return [
                'name' => 'Community Patron',
                'color' => 'light',
                'icon' => 'bi-heart',
                'badge' => 'community'
            ];
        }
    }

    /**
     * Display list of all candidates
     */
    public function candidates()
    {
        $candidates = Candidate::where('approved', true)
            ->with(['user', 'projects'])
            ->withCount('projects')
            ->orderBy('name')
            ->paginate(12);

        return view('user.candidates.index', compact('candidates'));
    }

    /**
     * Display a single candidate's profile
     */
    public function candidateProfile($slug)
    {
        $candidate = Candidate::where('slug', $slug)
            ->where('approved', true)
            ->with(['user', 'projects' => function($query) {
                $query->with(['phases'])->latest();
            }])
            ->firstOrFail();

        // Get active projects
        $activeProjects = $candidate->projects()
            ->where('status', 'ongoing')
            ->where('is_active', true)
            ->get();

        // Get completed projects
        $completedProjects = $candidate->projects()
            ->where('status', 'completed')
            ->get();

        // Get total project value
        $totalProjectValue = $candidate->projects()
            ->sum('estimated_budget');

        return view('user.candidates.profile', compact(
            'candidate',
            'activeProjects',
            'completedProjects',
            'totalProjectValue'
        ));
    }

    /**
     * Display list of all projects
     */
    public function projects()
    {
        $projects = Project::active()
            ->public()
            ->with(['candidate', 'phases'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    /**
     * Display a single project
     */
    public function projectShow($slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_public', true)
            ->with(['candidate', 'phases.media', 'contractors' => function($query) {
                $query->wherePivot('status', 'approved');
            }, 'donations' => function($query) {
                $query->where('approved', true)->latest()->take(10);
            }])
            ->firstOrFail();

        // Get total donations
        $totalDonations = $project->donations()
            ->where('approved', true)
            ->sum('amount');

        // Get donation count
        $donationCount = $project->donations()
            ->where('approved', true)
            ->count();

        // Get contributors count
        $contributorsCount = $project->donations()
            ->where('approved', true)
            ->distinct('contributor_id')
            ->count('contributor_id');

        // Check if current user is a contributor (if logged in)
        $isContributor = false;
        if (Auth::check() && Auth::user()->contributor) {
            $contributor = Contributor::where('user_id', Auth::id())->first();
            if ($contributor) {
                $isContributor = $project->donations()
                    ->where('contributor_id', $contributor->id)
                    ->where('approved', true)
                    ->exists();
            }
        }

        return view('projects.show', compact(
            'project',
            'totalDonations',
            'donationCount',
            'contributorsCount',
            'isContributor'
        ));
    }
}
