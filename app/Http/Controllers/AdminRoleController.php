<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ChangeRole;
use App\Models\Candidate;
use App\Models\Contractor;
use App\Models\Contributor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminRoleController extends Controller
{
    

    /**
     * Show all users with their roles and wallet balances
     */
    public function users()
    {
        $users = User::with(['candidate', 'contractor', 'contributor', 'wallet'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a single user's details
     */
    public function showUser(User $user)
    {
        $user->load(['candidate', 'contractor', 'contributor', 'wallet']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show all role change requests
     */
    public function roleRequests()
    {
        $requests = ChangeRole::with(['user', 'approver'])
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => ChangeRole::where('status', 'pending')->count(),
            'approved' => ChangeRole::where('status', 'approved')->count(),
            'rejected' => ChangeRole::where('status', 'rejected')->count(),
        ];

        return view('admin.roles.requests', compact('requests', 'stats'));
    }

    /**
     * Show pending role change requests
     */
    public function pendingRequests()
    {
        $requests = ChangeRole::with(['user', 'approver'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => $requests->total(),
        ];

        return view('admin.roles.pending', compact('requests', 'stats'));
    }

    /**
     * Show approved role change requests
     */
    public function approvedRequests()
    {
        $requests = ChangeRole::with(['user', 'approver'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(20);

        return view('admin.roles.approved', compact('requests'));
    }

    /**
     * Show rejected role change requests
     */
    public function rejectedRequests()
    {
        $requests = ChangeRole::with(['user', 'approver'])
            ->where('status', 'rejected')
            ->latest()
            ->paginate(20);

        return view('admin.roles.rejected', compact('requests'));
    }

    /**
     * Approve a role change request
     */
    public function approveRequest(ChangeRole $changeRole)
    {
        if ($changeRole->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        DB::beginTransaction();

        try {
            $user = $changeRole->user;
            $requestedRole = $changeRole->requested_role;
            $data = $changeRole->data ?? [];

            // Delete existing role records
            if ($user->candidate) {
                $user->candidate->delete();
            }
            if ($user->contractor) {
                $user->contractor->delete();
            }
            if ($user->contributor) {
                $user->contributor->delete();
            }

            // Create new role record
            switch ($requestedRole) {
                case 'candidate':
                    Candidate::create([
                        'user_id' => $user->id,
                        'name' => $data['name'] ?? $user->name,
                        'slug' => $data['slug'] ?? Str::slug($user->name),
                        'email' => $data['email'] ?? $user->email,
                        'phone' => $data['phone'] ?? null,
                        'district' => $data['district'] ?? null,
                        'state' => $data['state'] ?? null,
                        'gender' => $data['gender'] ?? null,
                        'bio' => $data['bio'] ?? null,
                        'photo' => $data['photo'] ?? null,
                        'approved' => true, // Auto-approve since admin is processing
                    ]);
                    break;

                case 'contractor':
                    Contractor::create([
                        'user_id' => $user->id,
                        'name' => $data['name'] ?? $user->name,
                        'slug' => $data['slug'] ?? Str::slug($user->name),
                        'email' => $data['email'] ?? $user->email,
                        'phone' => $data['phone'] ?? null,
                        'district' => $data['district'] ?? null,
                        'gender' => $data['gender'] ?? null,
                        'occupation' => $data['occupation'] ?? null,
                        'bio' => $data['bio'] ?? null,
                        'photo' => $data['photo'] ?? null,
                        'approved' => true,
                    ]);
                    break;

                case 'contributor':
                    Contributor::create([
                        'user_id' => $user->id,
                        'slug' => $data['slug'] ?? Str::slug($user->name),
                        'district' => $data['district'] ?? null,
                        'gender' => $data['gender'] ?? null,
                        'bio' => $data['bio'] ?? null,
                        'photo' => $data['photo'] ?? null,
                    ]);
                    break;
            }

            // Update user's role field (if you have one)
            $user->role = $requestedRole;
            $user->save();

            // Update the change request
            $changeRole->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

            DB::commit();

            return redirect()->route('checks.role-requests.pending')
                ->with('success', 'Role change approved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    /**
     * Reject a role change request
     */
    public function rejectRequest(Request $request, ChangeRole $changeRole)
    {
        if ($changeRole->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'admin_notes' => 'required|string|min:10'
        ]);

        $changeRole->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return redirect()->route('checks.role-requests.pending')
            ->with('success', 'Role change request rejected.');
    }

    /**
     * Manually change a user's role (admin only)
     */
    public function changeUserRole(Request $request, User $user)
    {
        $request->validate([
            'new_role' => 'required|in:candidate,contractor,contributor,none'
        ]);

        DB::beginTransaction();

        try {
            $newRole = $request->new_role;

            // Delete existing role records
            if ($user->candidate) {
                $user->candidate->delete();
            }
            if ($user->contractor) {
                $user->contractor->delete();
            }
            if ($user->contributor) {
                $user->contributor->delete();
            }

            // Create new role if not 'none'
            if ($newRole !== 'none') {
                switch ($newRole) {
                    case 'candidate':
                        Candidate::create([
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'slug' => Str::slug($user->name),
                            'email' => $user->email,
                            'approved' => true,
                        ]);
                        break;
                    case 'contractor':
                        Contractor::create([
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'slug' => Str::slug($user->name),
                            'email' => $user->email,
                            'approved' => true,
                        ]);
                        break;
                    case 'contributor':
                        Contributor::create([
                            'user_id' => $user->id,
                            'slug' => Str::slug($user->name),
                        ]);
                        break;
                }
            }

            // Update user's role field
            $user->role = $newRole === 'none' ? null : $newRole;
            $user->save();

            DB::commit();

            return redirect()->route('checks.users.index')
                ->with('success', 'User role updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update user role: ' . $e->getMessage());
        }
    }
}
