<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\AdminContractorController;

// Contractor Registration
Route::get('/contractor/register', [ContractorController::class, 'showApplyForm'])->name('contractor.register')->middleware('auth');
Route::post('/contractor/register', [ContractorController::class, 'store'])->name('contractor.store')->middleware('auth');



Route::middleware('auth')->group(function () {
// Contractor Projects
Route::get('/contractor/my-projects', [ContractorController::class, 'myProjects'])->name('contractor.my.projects');
Route::get('/contractor/my-projects/{project}', [ContractorController::class, 'showProject'])->name('contractor.my.projects.show');
Route::get('/contractor/past-projects', [ContractorController::class, 'pastProjects'])->name('contractor.past.projects');
Route::get('/projects/active', [ContractorController::class, 'active'])->name('contractor.projects.active');
        Route::post('/phases/{phase}/media', [ProjectMediaController::class, 'store'])
            ->name('contractor.phase.media.store');

// Admin Contractors Routes
 // Contractors management
    Route::resource('contractors', AdminContractorController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);
});

Route::get('/contractors/create', [AdminContractorController::class, 'create'])
->name('contractors.create');
    Route::post('/contractors', [AdminContractorController::class, 'store'])->name('contractors.store');
    // NEW: Professional Routes (using synonyms to avoid 404)
    Route::prefix('professionals')->name('professionals.')->group(function () {
        // Assign professional to project
        Route::post('/{contractor}/assign-project', [AdminContractorController::class, 'assignProject'])
            ->name('assign-project');

        // Toggle professional approval status
        Route::post('/{contractor}/toggle-approval', [AdminContractorController::class, 'toggleApproval'])
            ->name('toggle-approval');

        // Get professional details with assignments
        Route::get('/{contractor}/assignments', [AdminContractorController::class, 'getAssignments'])
            ->name('assignments');

        // Bulk assign professionals to project
        Route::post('/bulk-assign', [AdminContractorController::class, 'bulkAssign'])
            ->name('bulk-assign');

        // Get project candidates (professionals who can work on a project)
        Route::get('/project/{project}/candidates', [AdminContractorController::class, 'getProjectCandidates'])
            ->name('project-candidates');

            // Toggle professional approval status
        Route::post('/{contractor}/toggle-approval', [AdminContractorController::class, 'toggleApproval'])
            ->name('toggle-approval');

        Route::get('{contractor}/available-projects',
            [AdminContractorController::class, 'assignProjectPage']
        )->name('available-projects');

// Get available projects for a professional (contractor)
        // Route::get('/{contractor}/available-projects', [AdminContractorController::class,
        // 'getAvailableProjects'])
        //     ->name('available-projects');



    // Alternative: Vendor routes (another synonym option)
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/{contractor}/eligible-projects', [AdminContractorController::class, 'getAvailableProjects'])
            ->name('eligible-projects');

        Route::post('/{contractor}/assign-to-project', [AdminContractorController::class, 'assignProject'])
            ->name('assign-to-project');
    });
});

// Apply to Project
Route::get('/project/{project}/contractor', [ContractorController::class, 'showApplyForm'])->name('contractor.projects.form');
Route::post('/projects/{project}/apply', [ApplicationController::class, 'store'])->name('contractor.projects.apply');
