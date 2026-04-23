<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\SkemaController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// =====================
// ADMIN ROUTES
// =====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta');
        Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
        Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
        Route::get('/skema', [SkemaController::class, 'index'])->name('skema');
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');
        Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
    });

// =====================
// USER ROUTES
// =====================
Route::middleware(['auth', 'verified', 'role:user'])
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/skema', [\App\Http\Controllers\User\SkemaController::class, 'index'])->name('skema');
        Route::get('/skema/{id}', [\App\Http\Controllers\User\SkemaController::class, 'show'])->name('skema.show');
        Route::get('/jadwal', [\App\Http\Controllers\User\JadwalController::class, 'index'])->name('jadwal');
        Route::get('/hasil', [\App\Http\Controllers\User\HasilController::class, 'index'])->name('hasil');
        Route::get('/setting', [\App\Http\Controllers\User\SettingController::class, 'index'])->name('setting');
    });
// Profile (semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';