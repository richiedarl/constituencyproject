<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\UserCandidateController;

// Public Candidate Registration
Route::get('/candidate/register', [CandidateController::class, 'register'])->name('candidate.register');

Route::prefix('user/candidates')->name('user.candidates.')
->group(function () {
    Route::get('/create', [UserCandidateController::class, 'create'])->name('create');
    Route::post('/', [UserCandidateController::class, 'store'])->name('store');
});

Route::middleware(['auth'])->prefix('user/candidates')->name('user.candidates.')
->group(function () {
    // Profile
    Route::get('/dashboard', [UserCandidateController::class, 'dashboard'])->name('dashboard');
    Route::get('/{candidate}/edit', [UserCandidateController::class, 'edit'])->name('edit');
    Route::put('/{candidate}', [UserCandidateController::class, 'update'])->name('update');

    // Projects
    Route::get('/{candidate}/projects/create', [UserCandidateController::class, 'createProject'])->name('projects.create');
    Route::post('/{candidate}/projects', [UserCandidateController::class, 'storeProject'])->name('projects.store');

    // Phases
    Route::get('/{candidate}/projects/{project}/phases/create', [UserCandidateController::class, 'createPhase'])->name('projects.phases.create');
    Route::post('/{candidate}/projects/{project}/phases', [UserCandidateController::class, 'storePhase'])->name('projects.phases.store');
});

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
