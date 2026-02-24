<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    Project,
    User,
    Contributor,
    Wallet,
    Donation,
    Detail
};

class UserContributorController extends Controller
{
    /**
     * Show the appropriate form based on context:
     * - If project is provided: Show contribution form for that project
     * - If no project: Show contributor registration form
     */
    public function apply(Project $project = null)
    {
        $user = auth()->user();

        // Only allow users without roles to become contributors
        if ($user->candidate || $user->contractor) {
            abort(403, 'You are not allowed to contribute.');
        }

        // Check if user already has a contributor profile
        $existingContributor = Contributor::where('user_id', $user->id)->first();

        // Get bank details for the form
        $bankDetails = Detail::latest()->first();

        return view('user.contributors.apply', [
            'project' => $project,
            'contributor' => $existingContributor,
            'bankDetails' => $bankDetails
        ]);
    }

    /**
     * Handle form submission for both registration and contributions
     */
    public function saveApplyToProject(Request $request, Project $project = null)
    {
        $user = auth()->user();

        // Only users without roles can contribute
        if ($user->candidate || $user->contractor || $user->admin) {
            abort(403, 'You are not allowed to contribute. Contact Admin to change your position.');
        }

        // Check if this is registration (no project) or contribution (with project)
        $isRegistration = is_null($project);

        if ($isRegistration) {
            return $this->handleRegistration($request, $user);
        } else {
            return $this->handleContribution($request, $project, $user);
        }
    }

    /**
     * Handle contributor registration (no project)
     */
    protected function handleRegistration(Request $request, User $user)
    {
        // Check if already registered
        if (Contributor::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')
                ->with('info', 'You are already registered as a contributor.');
        }

        // Validate registration fields
        $request->validate([
            'bio' => 'required|string|max:1000',
            'district' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('contributors', 'public');
        }

        // Create contributor profile
        $contributor = Contributor::create([
            'user_id' => $user->id,
            'slug' => Str::slug($user->name . '-' . uniqid()),
            'bio' => $request->bio,
            'district' => $request->district,
            'gender' => $request->gender,
            'photo' => $photoPath,
        ]);

        // Create wallet
        Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! You are now registered as a contributor. You can fund your wallet to start supporting projects.');
    }

    /**
     * Handle contribution to a specific project
     */
    protected function handleContribution(Request $request, Project $project, User $user)
    {
        // Get or create contributor profile
        $contributor = Contributor::firstOrCreate(
            ['user_id' => $user->id],
            [
                'slug' => Str::slug($user->name . '-' . uniqid()),
                'bio' => $request->bio ?? 'New contributor',
                'district' => $request->district ?? 'Not specified',
                'gender' => $request->gender ?? 'other',
            ]
        );

        // Ensure wallet exists
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        // Prevent contributing to own project
        if ($project->candidate_id === optional($user->candidate)->id) {
            return back()->with('error', 'You cannot contribute to your own project.');
        }

        // Validate contribution
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:wallet,bank',
        ]);

        // Create donation record
        $donation = Donation::create([
            'contributor_id' => $contributor->id,
            'project_id' => $project->id,
            'amount' => $request->amount,
            'approved' => false, // admin approval required
        ]);

        // Handle wallet payment
        if ($request->payment_method === 'wallet') {
            if ($wallet->balance < $request->amount) {
                return back()->with('error', 'Insufficient wallet balance. Please fund your wallet first.');
            }

            $wallet->decrement('balance', $request->amount);

            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'type' => 'debit',
                'reference' => 'donation_' . uniqid(),
                'description' => 'Contribution to project: ' . $project->title,
                'status' => 'completed'
            ]);

            return redirect()->route('contributor.projects')
                ->with('success', 'Thank you! Your contribution has been submitted successfully.');
        }

        // Bank transfer - just show success message
        return redirect()->route('contributor.projects')
            ->with('success', 'Your contribution request has been submitted. Please complete the bank transfer to: ' .
                   ($this->getBankDetails() ?? 'our account'));
    }

    /**
     * Get bank details for display
     */
    protected function getBankDetails()
    {
        $details = Detail::latest()->first();
        if ($details) {
            return $details->bank_name . ' - ' . $details->account_name . ' - ' . $details->account_number;
        }
        return null;
    }
}
