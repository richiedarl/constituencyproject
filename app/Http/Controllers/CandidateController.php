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
        'state'  => 'nullable|string',

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
                'candidate' => 1,
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
            'user_id' => $user->id,
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
                'user_id'  => $user->id,
                'approved' => 1
            ]);


        /* ------------------------
         | Create Wallet
        -------------------------*/
        Wallet::create([
            'user_id' => $user->id,
            // 'candidate_id' => $candidate->id,
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

public function show(Candidate $candidate)
{
    $candidate->load([
        'user',
        'positions',
        'currentPosition',
        'wallet',
        'projects' => function ($query) {
            $query->with([
                'phases' => function ($q) {
                    $q->orderBy('created_at')
                      ->with(['media' => function ($img) {
                          $img->orderBy('created_at')->limit(5);
                      }]);
                }
            ]);
        }
    ]);

    // ✅ Query-based counts (scopes work here)
    $activeProjectsCount = $candidate->projects()
        ->active()
        ->count();

    // Compute progress per project (collection logic)
    $projects = $candidate->projects->map(function ($project) {

        $totalWeight = $project->phases->sum('weight');

        $completedWeight = $project->phases
            ->where('is_completed', true)
            ->sum('weight');

        $project->progress = $totalWeight > 0
            ? round(($completedWeight / $totalWeight) * 100)
            : 0;

        return $project;
    });

    return view(
        'admin.candidates.show',
        compact('candidate', 'projects', 'activeProjectsCount')
    );
}



public function fund(Request $request, Candidate $candidate)
{
    $data = $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    DB::transaction(function () use ($candidate, $data) {

        $wallet = $candidate->wallet()->firstOrCreate(
            ['candidate_id' => $candidate->id],
            ['user_id' => $candidate->user->id],
            ['balance' => 0, 'currency' => 'NGN']
        );

        $wallet->increment('balance', $data['amount']);
    });

    return back()->with('success', 'Candidate wallet funded successfully.');
}


}
