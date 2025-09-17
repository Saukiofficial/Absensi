<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\Panel\DashboardController as PanelDashboardController;
use App\Http\Controllers\Panel\LeaveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Laravel Breeze Authentication Routes
require __DIR__.'/auth.php';

// Rute "Gerbang" setelah login
// Ini akan menangkap redirect dari RouteServiceProvider::HOME
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Untuk 'siswa' dan 'wali'
    return redirect()->route('panel.dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Panel Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('guardians', GuardianController::class);
    Route::get('attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
    Route::get('simulation', [SimulationController::class, 'index'])->name('simulation.index');
    Route::post('simulation', [SimulationController::class, 'store'])->name('simulation.store');
});

// Student & Guardian Panel Routes
Route::middleware(['auth', 'role:siswa,wali'])->prefix('panel')->name('panel.')->group(function () {
    Route::get('/dashboard', [PanelDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:siswa')->prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('index');
        Route::get('/create', [LeaveController::class, 'create'])->name('create');
        Route::post('/', [LeaveController::class, 'store'])->name('store');
    });
});

