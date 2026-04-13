<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\SkemaController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\InformasiController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta');
    Route::get('/skema', [SkemaController::class, 'index'])->name('skema');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
    Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
