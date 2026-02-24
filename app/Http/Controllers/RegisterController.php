<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Contractor;
use App\Models\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request
     */
    public function register(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'role' => ['required', 'string', 'in:contractor,contributor,candidate'],
        'password' => ['required', 'confirmed', Password::defaults()],
        'terms' => ['required', 'accepted']
    ]);

    DB::beginTransaction();

    try {
        // Create JUST the user - NO role-specific profiles
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => false,
        ]);

 Wallet::firstOrCreate(
    ['user_id' => $user->id],
    [
        'balance' => 0,
        'currency' => 'NGN'
    ]
);
        DB::commit();

        event(new Registered($user));
        auth()->login($user);

        // Redirect to the appropriate application form based on role
        $redirectRoutes = [
            'contractor' => 'contractor.register',
            'contributor' => 'contributor.apply', // You'll need to create this
            'candidate' => 'candidate.register'
        ];

        return redirect()->route($redirectRoutes[$request->role])
            ->with('success', 'Registration successful! Please complete your application.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Registration failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
    }
}

}
