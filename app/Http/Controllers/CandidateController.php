<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{

    public function index()
{
    $candidates = Candidate::latest()->paginate(15);

    return view('admin.candidates.index', compact('candidates'));
}


    public function create()
    {
        return view('admin.candidates.create');
    }

    public function show(Candidate $candidate)
    {
        return view('candidates.show', [
            'candidate' => $candidate->load(['currentPosition', 'positions', 'wallet'])
        ]);
    }

 public function store(Request $request)
{
    $validated = $request->validate([
        // Basic info
        'title'     => 'nullable|string|max:20',
        'name'      => 'required|string|max:255',
        'email'     => 'nullable|email',
        'phone'     => 'nullable|string',
        'gender'    => 'nullable|string',
        'district'  => 'nullable|string',

        // Media
        'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        // Position
        'position'   => 'required|string|max:255',
        'year_from'  => 'nullable|integer|min:1900',
        'year_until' => 'nullable|integer|min:1900',
    ]);

    /* ------------------------
     | Prevent Duplicate Candidate
    -------------------------*/
    $existingCandidate = Candidate::where('email', $validated['email'])
        ->orWhere('phone', $validated['phone'])
        ->first();

    if ($existingCandidate) {
        return back()->with('error', 'Candidate already exists.');
    }

    DB::transaction(function () use ($request, $validated, &$candidate) {

        /* ------------------------
         | Generate Unique Username
        -------------------------*/
        $firstName = explode(' ', trim($validated['name']))[0];
        $baseUsername = strtolower($firstName);

        $count = User::where('username', 'like', $baseUsername . '%')->count();
        $extractedUsername = $count ? $baseUsername . $count : $baseUsername;

        /* ------------------------
         | Handle Photo Upload
        -------------------------*/
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('candidates', 'public');
        }

        /* ------------------------
         | Get or Create User
        -------------------------*/
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name'     => $validated['name'],
                'username' => $extractedUsername,
                'password' => bcrypt('password')
            ]
        );

            /* ------------------------
            | Generate Unique Candidate Slug
            -------------------------*/
            $baseSlug = Str::slug($validated['name']);

            $slugCount = Candidate::where('slug', 'like', $baseSlug . '%')->count();

            $slug = $slugCount ? $baseSlug . '-' . $slugCount : $baseSlug;

            /* ------------------------
            | Create Candidate
            -------------------------*/
            $candidate = Candidate::create([
                'title'    => $validated['title'] ?? null,
                'name'     => $validated['name'],
                'slug'     => $slug,
                'email'    => $validated['email'] ?? null,
                'phone'    => $validated['phone'] ?? null,
                'gender'   => $validated['gender'] ?? null,
                'district' => $validated['district'] ?? null,
                'photo'    => $photoPath,
                'user_id'  => $user->id
            ]);


        /* ------------------------
         | Create Wallet
        -------------------------*/
        Wallet::create([
            'candidate_id' => $candidate->id,
            'balance'      => 0,
            'currency'     => 'NGN',
        ]);

        /* ------------------------
         | Create Current Position
        -------------------------*/
        $candidate->positions()->create([
            'position'   => $validated['position'],
            'year_from'  => $validated['year_from'] ?? null,
            'year_until' => $validated['year_until'] ?? null,
            'is_current' => true,
        ]);
    });

    /* ------------------------
     | AJAX Response
    -------------------------*/
    if ($request->expectsJson()) {
        return response()->json([
            'success'   => true,
            'candidate' => [
                'id'    => $candidate->id,
                'name'  => $candidate->name,
                'photo' => $candidate->photo
                    ? asset('storage/' . $candidate->photo)
                    : null,
            ]
        ]);
    }

    return redirect()
        ->route('candidates.index')
        ->with('success', 'Candidate created successfully');
}

public function project_candidate_store(Request $request){
        $validated = $request->validate([
        // Basic info
        'title'     => 'nullable|string|max:20',
        'name'      => 'required|string|max:255',
        'email'     => 'nullable|email',
        'phone'     => 'nullable|string',
        'gender'    => 'nullable|string',
        'district'  => 'nullable|string',

        // Media
        'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5048',

        // Position
        'position'   => 'required|string|max:255',
        'year_from'  => 'nullable|integer|min:1900',
        'year_until' => 'nullable|integer|min:1900',
    ]);

    /* ------------------------
     | Prevent Duplicate Candidate
    -------------------------*/
    $existingCandidate = Candidate::where('email', $validated['email'])
        ->orWhere('phone', $validated['phone'])
        ->first();

    if ($existingCandidate) {
        return back()->with('error', 'Candidate already exists.');
    }

    DB::transaction(function () use ($request, $validated, &$candidate) {

        /* ------------------------
         | Generate Unique Username
        -------------------------*/
        $firstName = explode(' ', trim($validated['name']))[0];
        $baseUsername = strtolower($firstName);

        $count = User::where('username', 'like', $baseUsername . '%')->count();
        $extractedUsername = $count ? $baseUsername . $count : $baseUsername;

        /* ------------------------
         | Handle Photo Upload
        -------------------------*/
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('candidates', 'public');
        }

        /* ------------------------
         | Get or Create User
        -------------------------*/
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name'     => $validated['name'],
                'username' => $extractedUsername,
                'password' => bcrypt('password')
            ]
        );

            /* ------------------------
            | Generate Unique Candidate Slug
            -------------------------*/
            $baseSlug = Str::slug($validated['name']);

            $slugCount = Candidate::where('slug', 'like', $baseSlug . '%')->count();

            $slug = $slugCount ? $baseSlug . '-' . $slugCount : $baseSlug;

            /* ------------------------
            | Create Candidate
            -------------------------*/
            $candidate = Candidate::create([
                'title'    => $validated['title'] ?? null,
                'name'     => $validated['name'],
                'slug'     => $slug,
                'email'    => $validated['email'] ?? null,
                'phone'    => $validated['phone'] ?? null,
                'gender'   => $validated['gender'] ?? null,
                'district' => $validated['district'] ?? null,
                'photo'    => $photoPath,
                'user_id'  => $user->id
            ]);


        /* ------------------------
         | Create Wallet
        -------------------------*/
        Wallet::create([
            'candidate_id' => $candidate->id,
            'balance'      => 0,
            'currency'     => 'NGN',
        ]);

        /* ------------------------
         | Create Current Position
        -------------------------*/
        $candidate->positions()->create([
            'position'   => $validated['position'],
            'year_from'  => $validated['year_from'] ?? null,
            'year_until' => $validated['year_until'] ?? null,
            'is_current' => true,
        ]);
    });


  return redirect()
    ->back()
        ->with('success', 'Candidate created successfully');
}


}
