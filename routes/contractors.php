<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\AdminContractorController;

// Contractor Registration
Route::get('/contractor/register', [ContractorController::class, 'showApplyForm'])->name('contractor.register');
Route::post('/contractor/register', [ContractorController::class, 'store'])->name('contractor.store');



Route::middleware('auth')->group(function () {
// Contractor Projects
Route::get('/contractor/my-projects', [ContractorController::class, 'myProjects'])->name('contractor.my.projects');
Route::get('/contractor/my-projects/{project}', [ContractorController::class, 'showProject'])->name('contractor.my.projects.show');
Route::get('/contractor/past-projects', [ContractorController::class, 'pastProjects'])->name('contractor.past.projects');
Route::get('/projects/active', [ContractorController::class, 'active'])->name('contractor.projects.active');


// Admin Contractors Routes
 // Contractors management
    Route::resource('contractors', AdminContractorController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);
});

// Apply to Project
Route::get('/project/{project}/contractor', [ContractorController::class, 'showApplyForm'])->name('contractor.projects.form');
Route::post('/projects/{project}/apply', [ApplicationController::class, 'store'])->name('contractor.projects.apply');
