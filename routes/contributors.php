<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContributorController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserContributorController;

// Admin Contributors
Route::get('/admin/contributors/adminIndex', [ContributorController::class, 'adminIndex'])->name('admin.contributors.index');


// Contributor Registration
// Route::get('/contributor/register', [ContributorController::class, 'showApplyForm'])
// ->name('contributor.register');
// Route::post('/contributor/register', [ContributorController::class, 'apply'])
// ->name('contributor.store');

Route::get('/contributor/apply', [UserContributorController::class, 'apply'])
->name('contributor.apply')->middleware('auth');

// routes/web.php
Route::post('/contributor/save/apply', [UserContributorController::class, 'saveApplyToProject'])
    ->name('contributor.apply.save');

// Contributor Projects
Route::get('/contributor/my-projects', [UserContributorController::class, 'myProjects'])
->name('contributor.projects')->middleware('auth');

// Apply to Project (Contribute)
Route::get('/contributor/{project}/apply', [UserContributorController::class, 'apply'])
->name('contributor.project.apply')->middleware('auth');
Route::post('/contributor/{project}/apply', [UserContributorController::class, 'saveApplyToProject'])
->name('contributor.project.apply.save')->middleware('auth');
Route::get('/contributor/{project}/form', [UserContributorController::class, 'applyToProject'])
->name('contributor.project.form')->middleware('auth');


// Add this inside your existing auth middleware group or create a new group
Route::middleware(['web'])->group(function () {
    // Public contributor routes
    Route::get('/contributors', [IndexController::class, 'contributors'])->name('contributors.index');
    Route::get('/contributor/{slug?}/{id?}', [IndexController::class, 'contributorProfile'])
        ->name('contributor.profile')
        ->where(['id' => '[0-9]+', 'slug' => '[a-z0-9-]+']);
});
