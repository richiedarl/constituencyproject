<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Contractor;
use App\Models\Contributor;
use App\Models\ChangeRole;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();

        // Get the user's current role data
        $roleData = null;
        $currentRole = null;

        if ($user->candidate) {
            $currentRole = 'candidate';
            $roleData = $user->candidate;
        } elseif ($user->contractor) {
            $currentRole = 'contractor';
            $roleData = $user->contractor;
        } elseif ($user->contributor) {
            $currentRole = 'contributor';
            $roleData = $user->contributor;
        }

        // Check if user has a pending role change request
        $pendingRequest = ChangeRole::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        return view('profile.edit', compact('user', 'currentRole', 'roleData', 'pendingRequest'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Submit a role change request
     */
    public function changeRole(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending request
        $existingRequest = ChangeRole::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending role change request.');
        }

        $request->validate([
            'requested_role' => 'required|in:candidate,contractor,contributor',
        ]);

        // Determine current role
        $currentRole = null;
        if ($user->candidate) $currentRole = 'candidate';
        elseif ($user->contractor) $currentRole = 'contractor';
        elseif ($user->contributor) $currentRole = 'contributor';

        // Get data from the appropriate role if it exists
        $data = [];
        if ($currentRole === 'candidate' && $user->candidate) {
            $data = $user->candidate->toArray();
        } elseif ($currentRole === 'contractor' && $user->contractor) {
            $data = $user->contractor->toArray();
        } elseif ($currentRole === 'contributor' && $user->contributor) {
            $data = $user->contributor->toArray();
        }

        // Create change role request
        ChangeRole::create([
            'user_id' => $user->id,
            'current_role' => $currentRole,
            'requested_role' => $request->requested_role,
            'data' => $data,
            'status' => 'pending'
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Role change request submitted successfully. Admin will review it.');
    }

    /**
     * Delete the user's account
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
