<?php

use Database\Seeders\KingsleyMoghaluSeeder;
use App\Models\Candidate;
use App\Models\Contractor;
use App\Models\Contributor;
use App\Models\Donation;
use App\Models\Project;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Route;

it('maps every controller route to an existing action', function () {
    foreach (Route::getRoutes() as $route) {
        $action = $route->getActionName();

        if ($action === 'Closure' || ! str_contains($action, '@')) {
            continue;
        }

        [$controller, $method] = explode('@', $action, 2);

        $this->assertTrue(class_exists($controller), "Missing route controller: {$controller}");
        $this->assertTrue(method_exists($controller, $method), "Missing route action: {$action}");
    }
});

it('renders the seeded candidate and project public journey', function () {
    $this->seed(KingsleyMoghaluSeeder::class);

    $this->get('/')
        ->assertOk()
        ->assertSee('Community Enterprise and Skills Hub (Demo)');

    $this->get('/candidates')
        ->assertOk()
        ->assertSee('Kingsley Moghalu');

    $this->get('/candidate/kingsley-moghalu')
        ->assertOk()
        ->assertSee('Kingsley Moghalu')
        ->assertSee('Community Enterprise and Skills Hub (Demo)');

    $this->get('/projects?search=skills&state=Anambra&status=ongoing')
        ->assertOk()
        ->assertSee('Community Enterprise and Skills Hub (Demo)');

    $this->get('/project/community-enterprise-skills-hub-demo')
        ->assertOk()
        ->assertSee('Community Enterprise and Skills Hub (Demo)')
        ->assertSee('Planning')
        ->assertSee('Executing');

    $this->get('/report/candidate/kingsley-moghalu/preview')
        ->assertOk()
        ->assertSee('Kingsley Moghalu');
});

it('renders every static public information page', function () {
    $this->get('/about')->assertOk();
    $this->get('/documentation')->assertOk();
    $this->get('/services')->assertOk();
    $this->get('/contact')->assertOk();
    $this->get('/testimonials')->assertRedirect(route('services'));
    $this->get('/portfolios')->assertRedirect(route('candidates.index'));
});

it('opens the administration page at :path without a server error', function (string $path) {
    $admin = User::factory()->create(['admin' => true, 'role' => 'admin']);
    $this->actingAs($admin);

    $response = $this->get($path);
    $this->assertLessThan(500, $response->getStatusCode(), "Server error at {$path}");
})->with([
    '/home',
    '/candidates/all',
    '/candidates/create',
    '/admin/projects',
    '/admin/projects/active',
    '/admin/projects/create',
    '/applications/admin/all',
    '/submit/submissions',
    '/submit/submissions/pending',
    '/contractors',
    '/contractors/create',
    '/checks/users',
    '/checks/role-requests',
    '/submitted/reports',
    '/submitted/reports/pending',
    '/submitted/reports/approved',
    '/submitted/reports/rejected',
    '/wallet/pendingFundingRequests',
    '/wallet/pendingWithdrawals',
    '/wallet/walletSummary',
    '/wallet/allTransactions',
    '/admin/donations',
    '/admin/donations/pending',
    '/admin/donations/statistics',
    '/admin/contact',
]);

it('opens the seeded candidate account pages', function () {
    $this->seed(KingsleyMoghaluSeeder::class);
    $candidate = Candidate::where('slug', 'kingsley-moghalu')->firstOrFail();
    $project = $candidate->projects()->firstOrFail();
    $this->actingAs($candidate->user);

    $this->get('/home')->assertOk();
    $this->get('/user/candidates/dashboard')->assertOk();
    $this->get("/user/candidates/{$candidate->id}/edit")->assertOk();
    $this->get("/user/candidates/{$candidate->id}/projects/create")->assertSuccessful();
    $this->get("/user/candidates/{$candidate->id}/projects/{$project->id}/phases/create")->assertOk();
});

it('registers a contractor and opens the contractor account pages', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get('/contractor/register')->assertOk();
    $this->post('/contractor/register', [
        'company_name' => 'Audit Builders Ltd',
        'phone' => '08000000001',
        'experience_years' => 5,
        'specialization' => 'Civil engineering',
        'district' => 'Central District',
    ])->assertRedirect(route('dashboard'));

    expect(Contractor::where('user_id', $user->id)->exists())->toBeTrue();
    expect(Wallet::where('user_id', $user->id)->exists())->toBeTrue();

    $this->get('/contractor/profile')->assertOk();
    $this->get('/contractor/my-projects')->assertOk();
    $this->get('/contractor/past-projects')->assertOk();
});

it('registers a contributor and submits a project contribution', function () {
    $this->seed(KingsleyMoghaluSeeder::class);
    $project = Project::where('slug', 'community-enterprise-skills-hub-demo')->firstOrFail();
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get('/contributor/apply')->assertOk();
    $this->post('/contributor/save/apply', [
        'bio' => 'Community development supporter.',
        'district' => 'Central District',
        'gender' => 'other',
    ])->assertRedirect(route('dashboard'));

    $contributor = Contributor::where('user_id', $user->id)->firstOrFail();
    expect(Wallet::where('user_id', $user->id)->where('contributor_id', $contributor->id)->exists())->toBeTrue();

    $this->get("/contributor/{$project->id}/apply")->assertOk();
    $this->post("/contributor/{$project->id}/apply", [
        'amount' => 5000,
        'payment_method' => 'bank',
    ])->assertRedirect(route('contributor.projects'));

    expect(Donation::where('contributor_id', $contributor->id)->where('project_id', $project->id)->exists())->toBeTrue();
    $this->get('/contributor/my-projects')->assertOk();
    $this->get('/wallet/fund')->assertOk();
    $this->get('/wallet/transactions')->assertOk();
});
