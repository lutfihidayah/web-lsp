<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// =====================
// LANDING PAGE (PUBLIK)
// =====================
Route::get('/', function () {
    $informasi = \App\Models\Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();
    $skemas    = \App\Models\Skema::latest()->take(6)->get();
    return view('welcome', compact('informasi', 'skemas'));
});

// Daftar Skema Publik
Route::get('/sertifikasi', function () {
    $skemas = \App\Models\Skema::latest()->get();
    return view('skema-list', compact('skemas'));
})->name('guest.skema.index');

// Detail Skema Publik
Route::get('/sertifikasi/{id}', function ($id) {
    $skema = \App\Models\Skema::findOrFail($id);
    return view('skema-detail', compact('skema'));
})->name('guest.skema.show');

// Daftar Informasi Publik
Route::get('/berita', function () {
    $informasi = \App\Models\Informasi::where('status', 'Dipublikasikan')->latest()->get();
    return view('informasi-list', compact('informasi'));
})->name('guest.informasi.index');

// =====================
// SEMUA USER LOGIN
// =====================
Route::middleware('auth')->group(function () {

    // Dashboard (cek role di dalam controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---- SKEMA: semua role bisa baca (wildcard HARUS setelah grup CRUD admin) ----
    Route::get('/skema', [SkemaController::class, 'index'])->name('skema.index');

    // ---- JADWAL: semua role bisa lihat list ----
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    // ---- HASIL & SERTIFIKAT: admin lihat semua, user lihat milik sendiri ----
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{id}/sertifikat', [HasilController::class, 'sertifikat'])->name('hasil.sertifikat');

    // ---- ASESMEN: semua role akses (controller menangani perbedaan logic) ----
    Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen.index');
    Route::get('/asesmen/{id}/sertifikat', [AsesmenController::class, 'sertifikat'])->name('asesmen.sertifikat');

    // ---- PROFILE ----
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =====================
    // ADMIN & SUPERADMIN
    // =====================
    Route::middleware('role:admin,superadmin')->group(function () {

        // Skema CRUD — route statis /create & /edit harus SEBELUM wildcard /skema/{id}
        Route::get('/skema/create', [SkemaController::class, 'create'])->name('skema.create');
        Route::post('/skema', [SkemaController::class, 'store'])->name('skema.store');
        Route::get('/skema/{id}/edit', [SkemaController::class, 'edit'])->name('skema.edit');
        Route::put('/skema/{id}', [SkemaController::class, 'update'])->name('skema.update');
        Route::delete('/skema/{id}', [SkemaController::class, 'destroy'])->name('skema.destroy');

        // Jadwal CRUD
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        // Hasil CRUD
        Route::get('/hasil/create', [HasilController::class, 'create'])->name('hasil.create');
        Route::post('/hasil', [HasilController::class, 'store'])->name('hasil.store');
        Route::get('/hasil/{id}/edit', [HasilController::class, 'edit'])->name('hasil.edit');
        Route::put('/hasil/{id}', [HasilController::class, 'update'])->name('hasil.update');
        Route::delete('/hasil/{id}', [HasilController::class, 'destroy'])->name('hasil.destroy');

        // Peserta CRUD
        Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
        Route::get('/peserta/{id}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');

        // Informasi CRUD
        Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
        Route::get('/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
        Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
        Route::get('/informasi/{id}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
        Route::put('/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
        Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

        // Soal CRUD (Bank Soal)
        Route::resource('soal', SoalController::class)->except(['show']);

        // Laporan & Ekspor
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // ---- SKEMA & ASESMEN wildcard: didaftarkan SETELAH route statis /create & /edit ----
    // Ini memastikan /skema/create tidak ditangkap sebagai /skema/{id}
    Route::get('/skema/{id}', [SkemaController::class, 'show'])->name('skema.show');
    Route::get('/asesmen/{id}', [AsesmenController::class, 'show'])->name('asesmen.show');

    // =====================
    // ADMIN, SUPERADMIN & ASESOR: Konfirmasi Kehadiran & Monitor Asesmen
    // =====================
    Route::middleware('role:admin,superadmin,asesor')->group(function () {

        Route::post('/asesmen/absensi/{id}/konfirmasi', [AsesmenController::class, 'konfirmasiHadir'])->name('asesmen.konfirmasi');
        Route::post('/asesmen/{id}/konfirmasi-semua', [AsesmenController::class, 'konfirmasiSemua'])->name('asesmen.konfirmasi-semua');
    });

    // =====================
    // SUPERADMIN ONLY: Manajemen User & Sistem
    // =====================
    Route::middleware('role:superadmin')->group(function () {

        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // =====================
    // USER (PESERTA) ONLY
    // =====================
    Route::middleware('role:user')->group(function () {

        // Quiz
        Route::get('/asesmen/{id}/quiz', [AsesmenController::class, 'quiz'])->name('asesmen.quiz');
        Route::post('/asesmen/{id}/quiz/submit', [AsesmenController::class, 'submitQuiz'])->name('asesmen.quiz.submit');

        // Konfirmasi hadir mandiri (self-checkin)
        Route::post('/asesmen/hadir/{absensi}', [AsesmenController::class, 'hadir'])->name('asesmen.hadir');

        // Pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/checkout/{skema}', [PembayaranController::class, 'checkout'])->name('pembayaran.checkout');
        Route::get('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');
        Route::get('/pembayaran/sukses/{pendaftaran}', [PembayaranController::class, 'sukses'])->name('pembayaran.sukses');
        Route::get('/pembayaran/invoice/{pendaftaran}', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');
        Route::post('/pembayaran/simulate/{pendaftaran}', [PembayaranController::class, 'simulateSuccess'])->name('pembayaran.simulate');

        // Setting profil
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    });
});

// =====================
// MIDTRANS WEBHOOK (tanpa auth)
// =====================
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');

require __DIR__ . '/auth.php';