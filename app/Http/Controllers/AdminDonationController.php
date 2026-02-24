<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDonationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show all donations
     */
    public function index()
    {
        $donations = Donation::with(['contributor.user', 'project'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Donation::sum('amount'),
            'approved' => Donation::where('approved', true)->sum('amount'),
            'pending' => Donation::where('approved', false)->sum('amount'),
            'count' => Donation::count(),
        ];

        return view('admin.donations.index', compact('donations', 'stats'));
    }

    /**
     * Show pending donations
     */
    public function pending()
    {
        $donations = Donation::with(['contributor.user', 'project'])
            ->where('approved', false)
            ->latest()
            ->get();

        $stats = [
            'total_pending' => $donations->count(),
            'total_amount' => $donations->sum('amount'),
            'avg_amount' => $donations->avg('amount'),
            'unique_contributors' => $donations->pluck('contributor_id')->unique()->count(),
            'unique_projects' => $donations->pluck('project_id')->unique()->count(),
        ];

        return view('admin.donations.pending', compact('donations', 'stats'));
    }

    /**
     * Approve a donation
     */
    public function approve(Donation $donation)
    {
        if ($donation->approved) {
            return back()->with('error', 'Donation already approved.');
        }

        DB::beginTransaction();

        try {
            $donation->approved = true;
            $donation->save();

            // Update project raised amount
            $project = $donation->project;
            $project->raised_amount = ($project->raised_amount ?? 0) + $donation->amount;
            $project->save();

            DB::commit();

            return back()->with('success', 'Donation of ₦' . number_format($donation->amount) . ' approved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject a donation
     */
    public function reject(Request $request, Donation $donation)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        if ($donation->approved) {
            return back()->with('error', 'Cannot reject an approved donation.');
        }

        DB::beginTransaction();

        try {
            $donation->delete(); // Or soft delete with rejection reason

            DB::commit();

            return back()->with('success', 'Donation rejected successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Rejection failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Show donation statistics
     */
    public function statistics()
    {
        $totalDonations = Donation::where('approved', true)->sum('amount');
        $totalContributors = Donation::where('approved', true)->distinct('contributor_id')->count('contributor_id');
        $totalProjects = Donation::where('approved', true)->distinct('project_id')->count('project_id');

        $topProjects = Project::withSum('donations', 'amount')
            ->orderBy('donations_sum_amount', 'desc')
            ->limit(10)
            ->get();

        $topContributors = DB::table('donations')
            ->select('contributor_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->where('approved', true)
            ->groupBy('contributor_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return view('admin.donations.statistics', compact(
            'totalDonations',
            'totalContributors',
            'totalProjects',
            'topProjects',
            'topContributors'
        ));
    }
}
