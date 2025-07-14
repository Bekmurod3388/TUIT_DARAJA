<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OneIdController;

Route::get('/', function () {
    return redirect()->route('login');
});

// EGOV ID Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');

Route::get('/oneid/callback', [OneIdController::class, 'handleOneIdCallback'])->name('oneid.callback');

// Mening arizalarim sahifasi
Route::middleware('auth')->get('/my-applications', [\App\Http\Controllers\MyApplicationsController::class, 'index'])->name('my.applications');
Route::middleware('auth')->post('/applications', [\App\Http\Controllers\MyApplicationsController::class, 'store'])->name('applications.store');
Route::middleware('auth')->get('/my-applications/{id}/edit', [\App\Http\Controllers\MyApplicationsController::class, 'edit'])->name('applications.edit');
Route::middleware('auth')->post('/my-applications/{id}/update', [\App\Http\Controllers\MyApplicationsController::class, 'update'])->name('applications.update');
Route::middleware('auth')->get('/programs', [\App\Http\Controllers\ProgramsController::class, 'index'])->name('programs');

// Admin panel routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users');
    Route::get('/programs', [\App\Http\Controllers\Admin\ProgramsController::class, 'index'])->name('admin.programs');
    Route::get('/programs/create', [\App\Http\Controllers\Admin\ProgramsController::class, 'create'])->name('admin.programs.create');
    Route::post('/programs', [\App\Http\Controllers\Admin\ProgramsController::class, 'store'])->name('admin.programs.store');
    Route::get('/programs/{id}/edit', [\App\Http\Controllers\Admin\ProgramsController::class, 'edit'])->name('admin.programs.edit');
    Route::post('/programs/{id}', [\App\Http\Controllers\Admin\ProgramsController::class, 'update'])->name('admin.programs.update');
    Route::get('/applications', [\App\Http\Controllers\Admin\ApplicationsController::class, 'index'])->name('admin.applications');
    Route::post('/admin/applications/{id}/status', [\App\Http\Controllers\Admin\ApplicationsController::class, 'updateStatus'])->name('admin.applications.updateStatus');
    Route::get('/applications/{id}', [\App\Http\Controllers\Admin\ApplicationsController::class, 'show'])->name('admin.applications.show');
    // Foydalanuvchini tahrirlash sahifasi
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin.users.edit');
    // Foydalanuvchini yangilash (RESTful: PUT)
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('admin.users.update');
    // Foydalanuvchini o‘chirish (RESTful: DELETE)
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('admin.users.destroy');
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
