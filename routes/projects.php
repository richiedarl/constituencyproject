<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Admin / Projects
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin/projects')->group(function () {
Route::get('/', [ProjectController::class, 'index'])->name('admin.projects.index');
Route::get('/active', [ProjectController::class, 'adminActive'])->name('admin.projects.active');
Route::get('/create', [ProjectController::class, 'create'])->name('admin.projects.create');
Route::post('/store', [ProjectController::class, 'store'])->name('admin.projects.store');
Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
Route::get('/{project}/show', [ProjectController::class, 'show'])->name('admin.projects.show');
Route::put('/{project}/update', [ProjectController::class, 'update'])
->name('projects.update');
Route::delete('/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Update the latest phase of a project
Route::post(
    '/{project}/change-phase',
    [ProjectController::class, 'changePhase']
)->name('admin.projects.changePhase');

// Add media to a specific project phase
Route::post('/add-media', [ProjectController::class, 'addMediaToPhase'])
    ->name('admin.projects.addMedia');

Route::get('/add/media_to_phase/{phase}',[
    ProjectController::class, 'mediaPhasePage'
])->name('admin.mediaPage');

Route::delete('/media/{media}', [
    ProjectController::class,
    'deletePhaseMedia'
])->name('admin.projects.media.delete');
});

// User Routes

Route::get('/user/projects/index', [ProjectController::class, 'userIndex'])
->name('user.projects.index');

Route::get('/user/{project:slug}/show', [ProjectController::class, 'userShow'])
->name('user.projects.show');

Route::middleware('auth')->group(function () {
    Route::get('/user/projects/past-projects', [ProjectController::class, 'userPast'])
        ->name('user.projects.past-projects');
    Route::get('/user/projects/my-projects', [ProjectController::class, 'userMine'])
        ->name('user.mine.projects');
    Route::get('/user/completed', [ProjectController::class, 'userCompleted'])
        ->name('user.projects.completed');
    Route::post('/user/projects/{project}/upload-media', [ProjectController::class, 'contractorUploadMedia'])
        ->name('projects.uploadMedia');
});
