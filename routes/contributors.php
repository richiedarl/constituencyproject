<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContributorController;

// Admin Contributors
Route::get('/admin/contributors/adminIndex', [ContributorController::class, 'adminIndex'])->name('admin.contributors.index');


// Contributor Registration
Route::get('/contributor/register', [ContributorController::class, 'showApplyForm'])->name('contributor.register');
Route::post('/contributor/register', [ContributorController::class, 'apply'])->name('contributor.store');



// Contributor Projects
Route::get('/contributor/my-projects', [ContributorController::class, 'myProjects'])->name('contributor.projects');

// Apply to Project (Contribute)
Route::get('/contributor/{project}/apply', [ContributorController::class, 'applyToProject'])->name('contributor.project.apply');
Route::post('/contributor/{project}/apply', [ContributorController::class, 'saveApplyToProject'])->name('contributor.project.apply.save');
Route::get('/contributor/{project}/form', [ContributorController::class, 'applyToProject'])->name('contributor.project.form');

