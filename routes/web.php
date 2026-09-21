<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'home'])->name('landing');

Route::post('/register/store', [RegisterController::class, 'register'])->name('register.store');
Route::post('/login-validate', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login_validate');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/documentation', [PageController::class, 'documentation'])->name('documentation');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::middleware(['auth', 'admin'])->get('/admin/contact', [ContactController::class, 'adminIndex'])
    ->name('admin.contacts.index');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
});
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Dashboard (requires auth)
|--------------------------------------------------------------------------
*/
 Route::middleware('auth')->group(function () {

     Route::get('/home', [IndexController::class, 'index'])->name('dashboard');

//     // Profile management
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});




/*
|--------------------------------------------------------------------------
| Portfolios overview
|--------------------------------------------------------------------------
*/
Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');



/*
|--------------------------------------------------------------------------
| Public Candidate Profiles (catch-all, must be LAST)
|--------------------------------------------------------------------------
|
| This route must be **after all other routes** so it only matches
| if no other route matches. Pretty URLs like /john-doe will work.
|
*/


require __DIR__.'/applications.php';
require __DIR__.'/admin.php';
require __DIR__.'/candidates.php';
require __DIR__.'/contractors.php';
require __DIR__.'/projects.php';
require __DIR__.'/contributors.php';
require __DIR__.'/reports.php';
require __DIR__.'/wallet.php';
require __DIR__.'/auth.php';
require __DIR__.'/profile.php';

// Route::get('/{candidate:slug}', [CandidateController::class, 'show'])->name('candidate.show');
