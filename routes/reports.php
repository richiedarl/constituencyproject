<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserCandidateController;


Route::post('/report/generate', [ReportController::class, 'generate'])->name('report.generate');
Route::get('/report/candidate/{candidate}', [ReportController::class, 'show'])->name('report.candidate');


/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/
// Report Routes (Contractor)
Route::middleware(['auth'])->prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/phases/{projectId}', [ReportController::class, 'getPhases'])->name('phases');
    Route::post('/store', [ReportController::class, 'storeReport'])->name('store');
});

// Candidate Report Routes
Route::prefix('report/candidate/{slug}')->name('candidate.report.')->group(function () {
    Route::get('/preview', [ReportController::class, 'preview'])->name('preview');
    Route::get('/key', [ReportController::class, 'showKeyForm'])->name('key.form');
    Route::post('/validate', [ReportController::class, 'validateKey'])->name('validate');
    Route::get('/view', [ReportController::class, 'view'])->name('view');
    Route::get('/request', [ReportController::class, 'requestKeyForm'])->name('request.form');
    Route::post('/request', [ReportController::class, 'requestKey'])->name('request');
});

Route::middleware(['auth'])->group(function () {

    // ===== Report Key Management =====

    Route::get('/reports/keys', [ReportController::class, 'listKeys'])
        ->name('allKeys');

    Route::get('/reports/generatekey', [ReportController::class, 'createKeyForm'])
        ->name('generatekey');

    Route::post('/reports/generatekey', [ReportController::class, 'createKey'])
        ->name('generatekey.store');

    Route::get('/reports/expiredkeys', [ReportController::class, 'expiredKeys'])
        ->name('expiredkeys');


    // ===== Key Requests =====

    Route::get('/reports/keyrequests', [ReportController::class, 'keyRequests'])
        ->name('keyrequests');

    Route::post('/reports/keyrequests/{contact}/approve', [ReportController::class, 'approveKeyRequest'])
        ->name('keyrequests.approve');

    Route::post('/reports/keyrequests/{contact}/reject', [ReportController::class, 'rejectKeyRequest'])
        ->name('keyrequests.reject');


    // ===== Candidate Reports =====

    Route::get('/reports/candidates', [ReportController::class, 'allCandidates'])
        ->name('candidatesReports');

    Route::get('/reports/generate', [ReportController::class, 'generateReportForm'])
        ->name('generatereport');

    Route::get('/reports/candidate/{candidate}', [ReportController::class, 'adminCandidateReport'])
        ->name('candidate.report');

});

    // License Settings
    Route::get('/settings', [ReportController::class, 'licenseSettings'])->name('license.settings');
    Route::post('/settings', [ReportController::class, 'updateLicenseSettings'])->name('license.settings.update');
    Route::get('/logs', [ReportController::class, 'licenseLogs'])->name('license.logs');

// Admin Report Management
Route::middleware(['auth', 'admin'])->prefix('submitted/reports')->name('submitted.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'adminIndex'])->name('index');
    Route::get('/pending', [ReportController::class, 'pendingReports'])->name('pending');
    Route::get('/approved', [ReportController::class, 'approvedReports'])->name('approved');
    Route::get('/rejected', [ReportController::class, 'rejectedReports'])->name('rejected');
    Route::post('/{update}/approve', [ReportController::class, 'approveReport'])->name('approve');
    Route::post('/{update}/reject', [ReportController::class, 'rejectReport'])->name('reject');
    Route::get('/{update}', [ReportController::class, 'showReport'])->name('show');
});
