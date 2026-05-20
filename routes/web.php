<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\SkemaController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AsesmenAdminController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\AsesmenController;
use App\Http\Controllers\MidtransWebhookController;

// Landing page
Route::get('/', function () {
    $informasi = \App\Models\Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();
    $skemas = \App\Models\Skema::latest()->take(6)->get();
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
Route::get('/informasi', function () {
    $informasi = \App\Models\Informasi::where('status', 'Dipublikasikan')->latest()->get();
    return view('informasi-list', compact('informasi'));
})->name('guest.informasi.index');

// =====================
// ADMIN ROUTES
// =====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Peserta
        Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta');
        Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
        Route::get('/peserta/{id}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');

        // Skema
        Route::get('/skema', [SkemaController::class, 'index'])->name('skema');
        Route::get('/skema/create', [SkemaController::class, 'create'])->name('skema.create');
        Route::post('/skema', [SkemaController::class, 'store'])->name('skema.store');
        Route::get('/skema/{id}/edit', [SkemaController::class, 'edit'])->name('skema.edit');
        Route::put('/skema/{id}', [SkemaController::class, 'update'])->name('skema.update');
        Route::delete('/skema/{id}', [SkemaController::class, 'destroy'])->name('skema.destroy');

        // Jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        // Hasil
        Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');
        Route::get('/hasil/create', [HasilController::class, 'create'])->name('hasil.create');
        Route::post('/hasil', [HasilController::class, 'store'])->name('hasil.store');
        Route::get('/hasil/{id}/edit', [HasilController::class, 'edit'])->name('hasil.edit');
        Route::put('/hasil/{id}', [HasilController::class, 'update'])->name('hasil.update');
        Route::delete('/hasil/{id}', [HasilController::class, 'destroy'])->name('hasil.destroy');

        // Informasi
        Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
        Route::get('/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
        Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
        Route::get('/informasi/{id}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
        Route::put('/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
        Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

        // User Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');

        // Asesmen Monitoring
        Route::get('/asesmen', [AsesmenAdminController::class, 'index'])->name('asesmen');
        Route::get('/asesmen/{id}', [AsesmenAdminController::class, 'show'])->name('asesmen.show');
        Route::post('/asesmen/absensi/{id}/konfirmasi', [AsesmenAdminController::class, 'konfirmasiHadir'])->name('asesmen.konfirmasi');
        Route::post('/asesmen/{id}/konfirmasi-semua', [AsesmenAdminController::class, 'konfirmasiSemua'])->name('asesmen.konfirmasi-semua');
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
        Route::get('/hasil/{id}/sertifikat', [\App\Http\Controllers\User\HasilController::class, 'downloadSertifikat'])->name('hasil.sertifikat');
        Route::get('/setting', [\App\Http\Controllers\User\SettingController::class, 'index'])->name('setting');
        Route::post('/setting', [\App\Http\Controllers\User\SettingController::class, 'update'])->name('setting.update');

        // Pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::post('/pembayaran/checkout/{skema}', [PembayaranController::class, 'checkout'])->name('pembayaran.checkout');
        Route::get('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');
        Route::get('/pembayaran/sukses/{pendaftaran}', [PembayaranController::class, 'sukses'])->name('pembayaran.sukses');
        Route::get('/pembayaran/invoice/{pendaftaran}', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');
        Route::post('/pembayaran/simulate/{pendaftaran}', [PembayaranController::class, 'simulateSuccess'])->name('pembayaran.simulate');

        // Asesmen
        Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen');
        Route::get('/asesmen/{id}', [AsesmenController::class, 'show'])->name('asesmen.show');
        Route::post('/asesmen/hadir/{absensi}', [AsesmenController::class, 'hadir'])->name('asesmen.hadir');
        Route::get('/asesmen/{id}/quiz', [AsesmenController::class, 'quiz'])->name('asesmen.quiz');
        Route::post('/asesmen/{id}/quiz/submit', [AsesmenController::class, 'submitQuiz'])->name('asesmen.quiz.submit');
        Route::get('/asesmen/{id}/sertifikat', [AsesmenController::class, 'sertifikat'])->name('asesmen.sertifikat');
    });

// Profile (semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Midtrans Webhook (tanpa auth middleware)
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');

require __DIR__.'/auth.php';