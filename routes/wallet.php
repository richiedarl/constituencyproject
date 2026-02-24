<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminWalletController;


// Admin Routes

Route::middleware(['auth', 'admin'])->prefix('wallet')->group(function () {
    Route::get('/pendingFundingRequests', [AdminWalletController::class, 'pendingFundingRequests'])->name('pendingFundingRequests');

    Route::get('/pendingWithdrawals', [AdminWalletController::class, 'pendingWithdrawals'])
    ->name('pendingWithdrawals');

    Route::get('/walletSummary', [AdminWalletController::class, 'walletSummary'])
    ->name('walletSummary');

    Route::get('/allTransactions', [AdminWalletController::class, 'allTransactions'])
    ->name('allTransactions');

    Route::post('/approveFundingRequest', [AdminWalletController::class, 'approveFundingRequest'])
    ->name('approveFundingRequest');

    Route::post('/rejectFundingRequest', [AdminWalletController::class, 'rejectFundingRequest'])
    ->name('rejectFundingRequest');

    Route::post('/rejectWithdrawal', [AdminWalletController::class, 'rejectWithdrawal'])
    ->name('rejectWithdrawal');

    });

// Wallet Routes
Route::middleware(['auth'])->prefix('wallet')->name('wallet.')->group(function () {
    // All users can view transactions
    Route::get('/transactions', [WalletController::class, 'transactions'])->name('transactions');

    // Contributors only
    Route::get('/fund', [WalletController::class, 'fundForm'])->name('fund');
    Route::post('/fund', [WalletController::class, 'fund'])->name('fund.process');

    // Contractors only
    Route::get('/withdraw', [WalletController::class, 'withdrawalForm'])->name('withdraw');
    Route::post('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw.process');
});
