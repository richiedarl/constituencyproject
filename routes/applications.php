<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminApplicationController;

Route::get('applications/admin/all', [AdminApplicationController::class, 'index'])
            ->name('admin.applications.index');

// All users Applications
Route::get('/user/applications', [ApplicationController::class, 'index'])->name('user.applications.index');
Route::get('/user/approved/applications', [ApplicationController::class, 'approved'])->name('applications.approved');
Route::get('/user/pending/applications', [ApplicationController::class, 'pending'])->name('applications.pending');
Route::get('/user/cancelled/applications', [ApplicationController::class, 'cancelled'])->name('applications.cancelled');

// Admin Applications Routes
Route::get('/admin/application/all', [AdminApplicationController::class, 'index'])
->name('fetch.all.applications');

// To AVOID ERRORS, I use submit as prefix if necessary
Route::middleware(['auth', 'admin'])->prefix('submit')->group(function () {

    Route::get('/submissions',
        [AdminApplicationController::class, 'index']
    )->name('submissions.index');

    Route::get('/submissions/pending',
        [AdminApplicationController::class, 'pending']
    )->name('submissions.pending');

    Route::get('/submissions/{application}',
    [AdminApplicationController::class, 'show']
)->name('submissions.show');

    Route::post('/submissions/{application}/approve',
        [AdminApplicationController::class, 'approve']
    )->name('submissions.approve');


    Route::post('/submissions/{application}/reject',
        [AdminApplicationController::class, 'reject']
    )->name('submissions.reject');

});
