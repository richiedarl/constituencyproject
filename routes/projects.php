<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Admin / Projects
|--------------------------------------------------------------------------
*/

Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
Route::get('/projects/admin/active', [ProjectController::class, 'adminActive'])->name('admin.projects.active');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('admin.projects.store');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
Route::get('/projects/{project}/show', [ProjectController::class, 'show'])->name('admin.projects.show');
Route::put('/projects/{project}/update', [ProjectController::class, 'update'])
->name('projects.update');
Route::delete('/projects/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Update the latest phase of a project
Route::post(
    '/projects/{project}/change-phase',
    [ProjectController::class, 'changePhase']
)->name('admin.projects.changePhase');

// Add media to a specific project phase
Route::post('/projects/add-media', [ProjectController::class, 'addMediaToPhase'])
    ->name('admin.projects.addMedia');

Route::get('/add/media_to_phase/{phase}',[
    ProjectController::class, 'mediaPhasePage'
])->name('admin.mediaPage');

Route::delete('/projects/media/{media}', [
    ProjectController::class,
    'deletePhaseMedia'
])->name('admin.projects.media.delete');

// User Routes

Route::get('/user/projects/index', [ProjectController::class, 'userIndex'])
->name('user.projects.index');

Route::get('/user/projects/past-projects', [ProjectController::class, 'userPast'])
->name('user.projects.past-projects');

Route::get('/user/projects/my-projects', [ProjectController::class, 'userMine'])
->name('user.mine.projects');

Route::get('/user/{project}/show', [ProjectController::class, 'userShow'])
->name('user.projects.show');

Route::get('/user/completed', [ProjectController::class, 'userCompleted'])
->name('user.projects.completed');

// Only for Contractors
Route::post(
    '/user/projects/{project}/upload-media',
    [ProjectController::class, 'contractorUploadMedia']
)->name('projects.uploadMedia');

