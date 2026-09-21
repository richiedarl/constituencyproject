<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminFundController;
use App\Http\Controllers\AdminDonationController;

Route::middleware(['auth', 'admin'])->prefix('personal')->group(function () {

    Route::get('/funds', [AdminFundController::class, 'index'])
        ->name('personal.funds.index');

    Route::post('/funds/details', [AdminFundController::class, 'saveDetails'])
        ->name('personal.funds.details');

    Route::post('/funds/add', [AdminFundController::class, 'fundWallet'])
        ->name('personal.funds.add');

    Route::post('/funds/withdraw', [AdminFundController::class, 'withdraw'])
        ->name('personal.funds.withdraw');
});

Route::middleware(['auth', 'admin'])->prefix('admin/donations')->name('admin.donations.')->group(function () {
    Route::get('/', [AdminDonationController::class, 'index'])->name('index');
    Route::get('/pending', [AdminDonationController::class, 'pending'])->name('pending');
    Route::get('/statistics', [AdminDonationController::class, 'statistics'])->name('statistics');
    Route::post('/{donation}/approve', [AdminDonationController::class, 'approve'])->name('approve');
    Route::delete('/{donation}', [AdminDonationController::class, 'reject'])->name('reject');
});
