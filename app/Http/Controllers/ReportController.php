<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Update;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\ReportKey;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * ==================== CONTRACTOR REPORTS ====================
     */

 /**
 * Show form for submitting daily reports (Contractors only)
 * Route: /reports (GET)
 */
public function index()
{
    $user = Auth::user();

    // Only contractors can submit reports
    if (!$user->contractor) {
        abort(403, 'Only contractors can submit daily reports.');
    }

    // Get all approved applications for this contractor
    $applications = Application::where('contractor_id', $user->contractor->id)
        ->where('status', Application::STATUS_APPROVED)
        ->with(['project' => function($query) {
            $query->with('phases');
        }])
        ->get();

    // Extract projects from applications
    $projects = $applications->pluck('project')->filter();

    // Get recent updates for this contractor - DON'T filter by status
    // Include all updates regardless of status
    $recentUpdates = Update::with(['phase.project'])
        ->where('contractor_id', $user->contractor->id)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    // Debug: Uncomment to see what's being fetched
    dd([
        'updates_count' => $recentUpdates->count(),
        'updates' => $recentUpdates->toArray()
    ]);

    return view('user.contractors.reports.index', compact('projects', 'recentUpdates', 'user'));
}

   /**
 * Get phases for a selected project (AJAX)
 */
public function getPhases($projectId)
{
    $user = Auth::user();

    if (!$user || !$user->contractor) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Verify contractor has access to this project through an approved application
    $hasAccess = Application::where('contractor_id', $user->contractor->id)
        ->where('project_id', $projectId)
        ->where('status', Application::STATUS_APPROVED)
        ->exists();

    if (!$hasAccess) {
        return response()->json(['error' => 'You do not have access to this project'], 403);
    }

    // Get phases for the project - using correct column names
    try {
        $phases = ProjectPhase::where('project_id', $projectId)
            ->orderBy('id')
            ->get(['id', 'phase as name', 'status', 'description']); // 'phase' is the actual column name

        if ($phases->isEmpty()) {
            return response()->json(['message' => 'No phases found for this project', 'phases' => []]);
        }

        // Transform the data to include display information
        $transformedPhases = $phases->map(function($phase) {
            return [
                'id' => $phase->id,
                'name' => $phase->name, // This comes from 'phase as name'
                'phase' => $phase->phase ?? $phase->name, // Original phase value
                'status' => $phase->status,
                'description' => $phase->description,
                'display_name' => $phase->name . ($phase->status ? ' - ' . ucfirst($phase->status) : '')
            ];
        });

        return response()->json($transformedPhases);

    } catch (\Exception $e) {
        \Log::error('Error fetching phases: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to load phases: ' . $e->getMessage()], 500);
    }
}

/**
 * Store daily report
 */
public function storeReport(Request $request)
{
    $user = Auth::user();

    if (!$user->contractor) {
        return back()->with('error', 'Unauthorized');
    }

    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'phase_id' => 'required|exists:project_phases,id',
        'comment' => 'required|string|min:10',
        'photos' => 'nullable|array|max:5',
        'photos.*' => 'image|max:5120',
    ]);

    $hasAccess = Application::where('contractor_id', $user->contractor->id)
        ->where('project_id', $request->project_id)
        ->where('status', Application::STATUS_APPROVED)
        ->exists();

    if (!$hasAccess) {
        return back()->with('error', 'You do not have access to this project.');
    }

    DB::beginTransaction();

    try {
        // Get the phase to access its name for better description
        $phase = ProjectPhase::find($request->phase_id);

        // Create the update with contractor_id
        $update = Update::create([
            'phase_id' => $request->phase_id,
            'project_id' => $request->project_id,
            'contractor_id' => $user->contractor->id, // THIS WAS MISSING
            'comment' => $request->comment,
            'report_date' => now(),
            'status' => 'pending' // Default status
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reports/' . $request->project_id . '/phase-' . $request->phase_id, 'public');

                \App\Models\ProjectMedia::create([
                    'project_phase_id' => $request->phase_id,
                    'file_path' => $path,
                    'file_type' => 'image',
                    'update_id' => $update->id,
                    'uploaded_by' => $user->id
                ]);
            }
        }

        DB::commit();

        return redirect()->route('reports.index')
            ->with('success', 'Daily report submitted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Failed to submit report: ' . $e->getMessage());
        return back()->with('error', 'Failed to submit report: ' . $e->getMessage());
    }
}

    /**
     * ==================== PUBLIC CANDIDATE REPORTS (LICENSE KEYS) ====================
     */

    /**
     * Show preview of candidate report (locked)
     */
    public function preview($slug)
    {
        $candidate = Candidate::where('slug', $slug)
            ->where('approved', true)
            ->with([
                'positions',
                'projects'
            ])
            ->firstOrFail();

        $hasAccess = session('report_access_' . $candidate->id, false);

        return view('guest.reports.preview', compact('candidate', 'hasAccess'));
    }

    /**
     * Show form to enter license key
     */
    public function showKeyForm($slug)
    {
        $candidate = Candidate::where('slug', $slug)->firstOrFail();
        return view('guest.reports.key-form', compact('candidate'));
    }

    /**
     * Validate license key and grant access
     */
    public function validateKey(Request $request, $slug)
    {
        $request->validate([
            'license_key' => 'required|string'
        ]);

        $candidate = Candidate::where('slug', $slug)->firstOrFail();

        $key = ReportKey::where('key', $request->license_key)
            ->where('candidate_id', $candidate->id)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$key) {
            return back()->with('error', 'Invalid or expired license key.');
        }

        $key->update([
            'is_used' => true,
            'used_at' => now(),
            'used_by_ip' => $request->ip(),
            'used_by_user_agent' => $request->userAgent()
        ]);

        session(['report_access_' . $candidate->id => true]);

        return redirect()->route('candidate.report.view', $candidate->slug)
            ->with('success', 'Access granted. You can now view the full report.');
    }

    /**
     * View full candidate report (requires key or admin) - FIXED: Properly load all relationships
     */
    public function view($slug)
    {
        $candidate = Candidate::where('slug', $slug)
            ->where('approved', true)
            ->firstOrFail();

        // Load projects separately with all relationships
        $candidate->load([
            'user',
            'positions',
            'projects' => function($query) {
                // Don't filter by status - load all projects
                $query->orderBy('created_at', 'desc');
            },
            'projects.phases',
            'projects.phases.media',
            'projects.phases.updates' => function($query) {
                $query->latest();
            }
        ]);

        // Admin always has access
        if (Auth::check() && Auth::user()->admin) {
            return view('guest.reports.full', compact('candidate'));
        }

        // Check session for access
        if (!session('report_access_' . $candidate->id)) {
            return redirect()->route('candidate.report.key.form', $candidate->slug)
                ->with('error', 'Please enter a valid license key to access this report.');
        }

        return view('guest.reports.full', compact('candidate'));
    }

    /**
     * Show form for requesting license key
     */
    public function requestKeyForm($slug)
    {
        $candidate = Candidate::where('slug', $slug)->firstOrFail();
        return view('guest.reports.request-key', compact('candidate'));
    }

    /**
     * Submit request for license key
     */
    public function requestKey(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string'
        ]);

        $candidate = Candidate::find($request->candidate_id);

        Contact::create([
            'candidate_id' => $candidate->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->message,
            'subject' => 'License Key Request for ' . $candidate->name,
            'type' => 'license_request',
            'status' => 'pending',
            'is_read' => false
        ]);

        return back()->with('success', 'Your request has been submitted. Admin will contact you shortly.');
    }

    /**
     * ==================== ADMIN REPORTS & KEY MANAGEMENT ====================
     */

    /**
     * Generate candidate report (Admin only) - FIXED: Properly load all relationships without 'order' column
     */
    public function adminCandidateReport(Candidate $candidate)
    {
        if (!Auth::user()->admin) {
            abort(403, 'Only admins can generate candidate reports.');
        }

        // Load with all relationships, don't filter by status
        $candidate->load([
            'user',
            'projects' => function($query) {
                $query->orderBy('created_at', 'desc');
            },
            'projects.phases',
            'projects.phases.media',
            'projects.phases.updates' => function($query) {
                $query->latest();
            }
        ]);

        return view('admin.reports.candidate', compact('candidate'));
    }

    /**
     * Admin: List all license keys
     */
    public function listKeys()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $keys = ReportKey::with(['candidate', 'creator'])
            ->latest()
            ->paginate(20);

        $candidates = Candidate::approved()->orderBy('name')->get();

        return view('admin.reports.keys', compact('keys', 'candidates'));
    }

    /**
     * Admin: Create license key for a candidate
     */
    public function createKey(Request $request)
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'expires_days' => 'required|integer|min:1|max:365'
        ]);

        // Cast to integer explicitly
        $expiresDays = (int) $request->expires_days;

        $key = ReportKey::create([
            'candidate_id' => $request->candidate_id,
            'key' => strtoupper(Str::random(16)),
            'expires_at' => now()->addDays($expiresDays),
            'created_by' => Auth::id()
        ]);

        return back()->with('success', 'License key created: ' . $key->key);
    }

    /**
     * ==================== ADMIN KEY MANAGEMENT ====================
     */

    /**
     * Show all key requests
     */
    public function keyRequests()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $requests = Contact::where('type', 'license_request')
            ->with(['candidate'])
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => Contact::where('type', 'license_request')->where('status', 'pending')->count(),
            'approved' => Contact::where('type', 'license_request')->where('status', 'approved')->count(),
            'rejected' => Contact::where('type', 'license_request')->where('status', 'rejected')->count(),
        ];

        return view('admin.reports.key-requests', compact('requests', 'stats'));
    }

    /**
     * Approve a key request
     */
    public function approveKeyRequest(Contact $contact)
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        if ($contact->type !== 'license_request') {
            return back()->with('error', 'Invalid request type.');
        }

        DB::beginTransaction();

        try {
            // Create a new license key
            $key = ReportKey::create([
                'candidate_id' => $contact->candidate_id,
                'key' => strtoupper(Str::random(16)),
                'expires_at' => now()->addDays(30),
                'created_by' => Auth::id()
            ]);

            // Update contact status
            $contact->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

            DB::commit();

            return back()->with('success', 'Key request approved. Key: ' . $key->key);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    /**
     * Reject a key request
     */
    public function rejectKeyRequest(Request $request, Contact $contact)
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        $contact->update([
            'status' => 'rejected',
            'admin_notes' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => Auth::id()
        ]);

        return back()->with('success', 'Key request rejected.');
    }

    /**
     * Show form to create new key
     */
    public function createKeyForm()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $candidates = Candidate::approved()->orderBy('name')->get();
        return view('admin.reports.create-key', compact('candidates'));
    }

    /**
     * Show expired keys
     */
    public function expiredKeys()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $keys = ReportKey::with(['candidate', 'creator'])
            ->where('expires_at', '<', now())
            ->orWhere('is_used', true)
            ->latest()
            ->paginate(20);

        return view('admin.reports.expired-keys', compact('keys'));
    }

    /**
     * Show all candidates for report generation
     */
    public function allCandidates()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $candidates = Candidate::withCount(['projects'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.reports.all-candidates', compact('candidates'));
    }

    /**
     * Show report generation page
     */
    public function generateReportForm()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $candidates = Candidate::approved()->orderBy('name')->get();
        return view('admin.reports.generate', compact('candidates'));
    }

    /**
     * License settings
     */
    public function licenseSettings()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $settings = [
            'default_expiry_days' => 30,
            'allow_multiple_uses' => false,
            'require_approval' => true,
            'price' => 5000,
        ];

        return view('admin.reports.settings', compact('settings'));
    }

    /**
     * Update license settings
     */
    public function updateLicenseSettings(Request $request)
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $request->validate([
            'default_expiry_days' => 'required|integer|min:1|max:365',
            'allow_multiple_uses' => 'boolean',
            'require_approval' => 'boolean',
            'price' => 'required|numeric|min:0'
        ]);

        // Store in session or database as needed
        session([
            'license.default_expiry_days' => $request->default_expiry_days,
            'license.allow_multiple_uses' => $request->allow_multiple_uses,
            'license.require_approval' => $request->require_approval,
            'license.price' => $request->price
        ]);

        return back()->with('success', 'License settings updated successfully.');
    }

    /**
     * View access logs
     */
    public function licenseLogs()
    {
        if (!Auth::user()->admin) {
            abort(403);
        }

        $logs = ReportKey::with(['candidate', 'creator'])
            ->whereNotNull('used_at')
            ->latest('used_at')
            ->paginate(20);

        return view('admin.reports.logs', compact('logs'));
    }

/**
 * ==================== ADMIN REPORT MANAGEMENT ====================
 */

/**
 * Admin: List all reports
 */
public function adminIndex()
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $reports = Update::with(['phase.project', 'contractor.user'])
        ->latest()
        ->paginate(20);

    $stats = [
        'total' => Update::count(),
        'pending' => Update::where('status', 'pending')->count(),
        'approved' => Update::where('status', 'approved')->count(),
        'rejected' => Update::where('status', 'rejected')->count(),
    ];

    return view('admin.reports.index', compact('reports', 'stats'));
}

/**
 * Admin: Show pending reports
 */
public function pendingReports()
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $reports = Update::with(['phase.project', 'contractor.user'])
        ->where('status', 'pending')
        ->latest()
        ->paginate(20);

    $stats = [
        'total' => $reports->total(),
        'pending' => $reports->total(),
    ];

    return view('admin.reports.pending', compact('reports', 'stats'));
}

/**
 * Admin: Show approved reports
 */
public function approvedReports()
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $reports = Update::with(['phase.project', 'contractor.user'])
        ->where('status', 'approved')
        ->latest()
        ->paginate(20);

    return view('admin.reports.approved', compact('reports'));
}

/**
 * Admin: Show rejected reports
 */
public function rejectedReports()
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $reports = Update::with(['phase.project', 'contractor.user'])
        ->where('status', 'rejected')
        ->latest()
        ->paginate(20);

    return view('admin.reports.rejected', compact('reports'));
}

/**
 * Admin: Show single report
 */
public function showReport(Update $update)
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $update->load(['phase.project', 'contractor.user', 'photos']);

    return view('admin.reports.show', compact('update'));
}

/**
 * Admin: Approve a report
 */
public function approveReport(Update $update)
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    DB::beginTransaction();

    try {
        $update->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        DB::commit();

        return redirect()->route('submmitted.reports.pending')
            ->with('success', 'Report approved successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to approve report: ' . $e->getMessage());
    }
}

/**
 * Admin: Reject a report
 */
public function rejectReport(Request $request, Update $update)
{
    if (!Auth::user()->admin) {
        abort(403);
    }

    $request->validate([
        'rejection_reason' => 'required|string|min:10'
    ]);

    DB::beginTransaction();

    try {
        $update->update([
            'status' => 'rejected',
            'admin_notes' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => Auth::id()
        ]);

        DB::commit();

        return redirect()->route('admin.reports.pending')
            ->with('success', 'Report rejected successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to reject report: ' . $e->getMessage());
    }
}
    }

