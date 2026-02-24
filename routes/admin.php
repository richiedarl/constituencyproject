<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminFundController;

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
