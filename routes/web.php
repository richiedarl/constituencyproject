<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController; 
use App\Http\Controllers\CandidateController; 
use App\Http\Controllers\ContactController; 
use App\Http\Controllers\ProjectController; 
use App\Http\Controllers\ApplicationController; 
use App\Http\Controllers\ReportController; 
use App\Http\Controllers\PortfolioController; 

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});



Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/admin/contact', [ContactController::class, 'all_contacts'])->name('admin.contacts.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginValidate'])->name('login_validate');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Dashboard (requires auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('all/applications',[
    ApplicationController::class, 'applications'
])->name('admin.applications.index');

/*
|--------------------------------------------------------------------------
| Admin / Projects
|--------------------------------------------------------------------------
*/

Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
Route::get('/projects/active', [ProjectController::class, 'active'])->name('projects.active');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
Route::get('/projects/{project}/show', [ProjectController::class, 'show'])->name('admin.projects.show');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Update the latest phase of a project
Route::post(
    '/projects/{project}/change-phase',
    [ProjectController::class, 'changePhase']
)->name('admin.projects.changePhase');

Route::get('add/media_to_phase/{phase}',[
    ProjectController::class, 'mediaPhasePage'
])->name('admin.mediaPage');
// Add media to a specific project phase
Route::post('projects/add-media', [ProjectController::class, 'addMediaToPhase'])
    ->name('admin.projects.addMedia');

Route::delete('projects/media/{media}', [
    ProjectController::class,
    'deletePhaseMedia'
])->name('admin.projects.media.delete');

/*
|--------------------------------------------------------------------------
| Admin / Candidates
|--------------------------------------------------------------------------
*/
Route::prefix('candidates')->group(function () {
    Route::get('/', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/create', [CandidateController::class, 'create'])->name('candidates.create');
    Route::post('store', [CandidateController::class, 'store'])->name('candidates.store');
    Route::get('/{candidate}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
    Route::post('/{candidate}/destroy', [CandidateController::class, 'destroy'])->name('candidates.destroy');
    Route::put('/{candidate}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::get('/{candidate}', [CandidateController::class, 'show'])->name('candidates.show');
    
        Route::post(
            'admin/ajax-store',
            [CandidateController::class, 'store']
        )->name('admin.candidates.store.ajax');
    
        Route::post(
            'admin/project-level/store',
            [CandidateController::class, 'project_candidate_store']
        )->name('project_candidate_store');

    // Candidate portfolio
    Route::get('/{candidate}/portfolio', [PortfolioController::class, 'show'])->name('candidates.portfolio');
    Route::post('/{candidate}/projects', [PortfolioController::class, 'attachProject'])->name('candidates.projects.attach');
});

// This route is going to the same controller method as the candidates.store

/*
|--------------------------------------------------------------------------
| Portfolios overview
|--------------------------------------------------------------------------
*/
Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::post('/login-validate', [LoginController::class, 'loginValidate'])
    ->name('login_validate');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



/*
|--------------------------------------------------------------------------
| Public Candidate Profiles (catch-all, must be LAST)
|--------------------------------------------------------------------------
|
| This route must be **after all other routes** so it only matches
| if no other route matches. Pretty URLs like /john-doe will work.
|
*/


Route::get('/{candidate:slug}', [CandidateController::class, 'show'])->name('candidate.show');



require __DIR__.'/auth.php';
