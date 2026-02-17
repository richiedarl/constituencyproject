<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

Route::get('applications/admin/all', [ApplicationController::class, 'adminIndex'])
            ->name('admin.applications.index');

// Contractor View
Route::get('/my-applications', [ApplicationController::class, 'index'])->name('applications.index');

// Admin Applications Routes
Route::get('/admin/application/all', [ApplicationController::class, 'adminIndex'])->name('fetch.all.applications');

