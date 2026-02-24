<?

// Public routes
Route::get('/', [IndexController::class, 'home'])->name('landing');
Route::get('/contributors', [IndexController::class, 'contributors'])->name('contributors.index');
Route::get('/contributor/{slug?}/{id?}', [IndexController::class, 'contributorProfile'])->name('contributor.profile');
Route::get('/candidates', [IndexController::class, 'candidates'])->name('candidates.index');
Route::get('/candidate/{slug}', [IndexController::class, 'candidateProfile'])->name('candidate.public.show');
Route::get('/projects', [IndexController::class, 'projects'])->name('projects.index');
Route::get('/project/{slug}', [IndexController::class, 'projectShow'])->name('project.public.show');

// Candidate report preview (locked)
Route::get('/report/candidate/{slug}/preview', [ReportController::class, 'preview'])->name('candidate.report.preview');
