<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Mendukung pengecekan multi-role, contoh:
     *   route()->middleware('role:admin,superadmin')
     *   route()->middleware('role:asesor')
     *
     * Selain pengecekan role, middleware ini juga memastikan
     * user yang dinonaktifkan admin (status = nonaktif) tidak bisa mengakses sistem
     * meskipun sesi login mereka belum berakhir.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        // Blokir user yang sudah dinonaktifkan meskipun sesi masih aktif
        if ($user->status !== 'aktif') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak. Peran Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}