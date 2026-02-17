<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Application;
use App\Models\Contractor;
use App\Models\Candidate;
use App\Models\Contributor;
use App\Models\Wallet;
use Carbon\Carbon;
use Auth;

class IndexController extends Controller
{
    public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('message', 'Please login to access the dashboard');
    }

    $user = Auth::user();
    $data = [];

    // Common data for all users
    $data['recentProjects'] = Project::with(['candidate', 'phases'])
        ->latest()
        ->take(5)
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
        $contractorId = $user->id;

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

        // Wallet Balance
        $wallet = Wallet::where('user_id', $contractorId)->first();
        $data['walletBalance'] = $wallet ? $wallet->balance : 0;

        // Total earnings from all completed projects
        $data['totalEarnings'] = Application::where('contractor_id', $contractorId)
            ->where('status', 'approved')
            ->whereHas('project', function($query) {
                $query->where('status', 'completed');
            })
            ->sum('amount_deposited') ?? 0;
    }

    // Contributor specific data
    if ($user->contributor) {
        $contributorId = $user->id;

        // My Total Contributions (approved donations)
        $data['myTotalContributions'] = Donation::where('contributor_id', $contributorId)
            ->where('status', 'approved')
            ->count();

        // Total Amount Donated
        $data['totalAmountDonated'] = Donation::where('contributor_id', $contributorId)
            ->where('status', 'approved')
            ->sum('amount') ?? 0;

        // Pending Contributions
        $data['pendingContributions'] = Donation::where('contributor_id', $contributorId)
            ->where('status', 'pending')
            ->count();

        // Projects I've Supported
        $data['supportedProjects'] = Project::whereIn('id', function($query) use ($contributorId) {
            $query->select('project_id')
                ->from('donations')
                ->where('contributor_id', $contributorId)
                ->where('status', 'approved');
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

        // Wallet Balance
        $wallet = Wallet::where('user_id', $contributorId)->first();
        $data['walletBalance'] = $wallet ? $wallet->balance : 0;

        // Active Candidates
        $data['activeCandidates'] = Candidate::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    return view('dashboard', $data);
}

        public function home()
{
    $projects = Project::active()
        ->public()
        ->with(['candidate', 'phases'])
        ->inRandomOrder()
        ->paginate(9);

    $topContributors = Contributor::withSum('donations', 'amount')
        ->orderByDesc('donations_sum_amount')
        ->take(10)
        ->get();

    $candidates = Candidate::take(6)->get(); // optional, for display

    return view('index', compact('projects', 'topContributors', 'candidates'));
}

}
