<?php

use App\Http\Controllers\Admin\LogoutController as AdminLogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OneIdController;

Route::get('/lang/{locale}', [LocaleController::class, 'update'])->name('language.switch');

// --- Public routes ---
Route::redirect('/', '/login');

// --- User authentication ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.post');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.post');
Route::post('/logout', LogoutController::class)->name('logout');

// --- EGOV ID Authentication ---
Route::get('/oneid/login', [OneIdController::class, 'redirectToOneId'])->name('oneid.login');
Route::get('/oneid/callback', [OneIdController::class, 'handleOneIdCallback'])->name('oneid.callback');

// --- User application routes ---
Route::middleware('auth')->group(function () {
    Route::get('/my-applications', [\App\Http\Controllers\MyApplicationsController::class, 'index'])->name('my.applications');
    Route::post('/applications', [\App\Http\Controllers\MyApplicationsController::class, 'store'])->middleware('throttle:10,1')->name('applications.store');
    Route::get('/my-applications/{id}/edit', [\App\Http\Controllers\MyApplicationsController::class, 'edit'])->name('applications.edit');
    Route::post('/my-applications/{id}/update', [\App\Http\Controllers\MyApplicationsController::class, 'update'])
        ->middleware('throttle:10,1')
        ->name('applications.update');
    Route::get('/programs', [\App\Http\Controllers\ProgramsController::class, 'index'])->name('programs');
    Route::get('/applications/{id}/pay', [\App\Http\Controllers\MyApplicationsController::class, 'pay'])->name('applications.pay');
    Route::get('/applications/{id}/certificate', [\App\Http\Controllers\MyApplicationsController::class, 'certificate'])->name('applications.certificate');
    Route::get('/applications/{id}/file/{field}', [\App\Http\Controllers\MyApplicationsController::class, 'downloadFile'])->name('applications.file');
});
Route::get('/payme/callback', [\App\Http\Controllers\PaymeController::class, 'return'])->name('payme.return');
Route::post('/payme/callback', [\App\Http\Controllers\PaymeController::class, 'merchant'])
    ->middleware('throttle:60,1')
    ->name('payme.merchant');

// --- Admin authentication (login/logout) ---
Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\Admin\LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('admin.login.post');
    Route::post('/logout', AdminLogoutController::class)->name('admin.logout');
});

// --- Admin panel (protected) ---
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/programs', [\App\Http\Controllers\Admin\ProgramsController::class, 'index'])->name('admin.programs');
    Route::get('/programs/create', [\App\Http\Controllers\Admin\ProgramsController::class, 'create'])->name('admin.programs.create');
    Route::post('/programs', [\App\Http\Controllers\Admin\ProgramsController::class, 'store'])->name('admin.programs.store');
    Route::get('/programs/{id}/edit', [\App\Http\Controllers\Admin\ProgramsController::class, 'edit'])->name('admin.programs.edit');
    Route::post('/programs/{id}', [\App\Http\Controllers\Admin\ProgramsController::class, 'update'])->name('admin.programs.update');
    Route::delete('/programs/{id}', [\App\Http\Controllers\Admin\ProgramsController::class, 'destroy'])->name('admin.programs.destroy');

    Route::get('/applications', [\App\Http\Controllers\Admin\ApplicationsController::class, 'index'])->name('admin.applications');
    Route::post('/applications/{id}/status', [\App\Http\Controllers\Admin\ApplicationsController::class, 'updateStatus'])->name('admin.applications.updateStatus');
    Route::get('/applications/{id}', [\App\Http\Controllers\Admin\ApplicationsController::class, 'show'])->name('admin.applications.show');
    Route::post('/applications/{id}/score', [\App\Http\Controllers\Admin\ApplicationsController::class, 'setScore'])->name('admin.applications.setScore');

    Route::get('/subjects', [\App\Http\Controllers\Admin\SubjectsController::class, 'index'])->name('admin.subjects');
    Route::get('/subjects/create', [\App\Http\Controllers\Admin\SubjectsController::class, 'create'])->name('admin.subjects.create');
    Route::post('/subjects', [\App\Http\Controllers\Admin\SubjectsController::class, 'store'])->name('admin.subjects.store');
    Route::get('/subjects/{id}/edit', [\App\Http\Controllers\Admin\SubjectsController::class, 'edit'])->name('admin.subjects.edit');
    Route::post('/subjects/{id}', [\App\Http\Controllers\Admin\SubjectsController::class, 'update'])->name('admin.subjects.update');
    Route::delete('/subjects/{id}', [\App\Http\Controllers\Admin\SubjectsController::class, 'destroy'])->name('admin.subjects.destroy');

    Route::get('/commissions', [\App\Http\Controllers\Admin\CommissionsController::class, 'index'])->name('admin.commissions');
    Route::get('/commissions/create', [\App\Http\Controllers\Admin\CommissionsController::class, 'create'])->name('admin.commissions.create');
    Route::post('/commissions', [\App\Http\Controllers\Admin\CommissionsController::class, 'store'])->name('admin.commissions.store');
    Route::get('/commissions/{id}/edit', [\App\Http\Controllers\Admin\CommissionsController::class, 'edit'])->name('admin.commissions.edit');
    Route::put('/commissions/{id}', [\App\Http\Controllers\Admin\CommissionsController::class, 'update'])->name('admin.commissions.update');
    Route::delete('/commissions/{id}', [\App\Http\Controllers\Admin\CommissionsController::class, 'destroy'])->name('admin.commissions.destroy');
});

// --- Admin program names CRUD ---
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('program-names', \App\Http\Controllers\Admin\ProgramNameController::class)->except(['show']);
});
