<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminRoleController;

// Profile Management
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/change-role', [ProfileController::class, 'changeRole'])->name('profile.change-role');
});

// Admin Role Management
Route::middleware(['auth', 'admin'])->prefix('checks')->name('checks.')->group(function () {
    // Users
    Route::get('/users', [AdminRoleController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminRoleController::class, 'showUser'])->name('users.show');
    Route::post('/users/{user}/change-role', [AdminRoleController::class, 'changeUserRole'])
    ->name('users.change-role');

    // Role Change Requests
    Route::get('/role-requests', [AdminRoleController::class, 'roleRequests'])
    ->name('role-requests.index');
    Route::get('/role-requests/pending', [AdminRoleController::class, 'pendingRequests'])
    ->name('role-requests.pending');

    Route::get('/role-requests/approved', [AdminRoleController::class, 'approvedRequests'])
    ->name('role-requests.approved');

    Route::get('/role-requests/rejected', [AdminRoleController::class, 'rejectedRequests'])
    ->name('role-requests.rejected');
    Route::post('/role-requests/{changeRole}/approve', [AdminRoleController::class, 'approveRequest'])
    ->name('role-requests.approve');
    Route::post('/role-requests/{changeRole}/reject', [AdminRoleController::class, 'rejectRequest'])
    ->name('role-requests.reject');
});
