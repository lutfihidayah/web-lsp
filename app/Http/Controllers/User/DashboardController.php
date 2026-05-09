<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use App\Models\Pendaftaran;
use App\Models\Informasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Data dari pendaftaran & asesmen user
        $pendaftaranPaid = Pendaftaran::where('user_id', $user->id)
            ->where('status', 'paid')
            ->pluck('id');

        $asesmens = Asesmen::whereIn('pendaftaran_id', $pendaftaranPaid)->get();

        $skemaCount      = $pendaftaranPaid->count();
        $kompeten        = $asesmens->where('status', 'lulus')->count();
        $totalSertifikat = $asesmens->whereNotNull('no_sertifikat')->count();
        $dalamProses     = $asesmens->where('status', 'berlangsung')->count();

        // Jadwal mendatang milik user
        $jadwalCount = Pendaftaran::where('user_id', $user->id)
            ->where('status', 'paid')
            ->whereNotNull('jadwal_id')
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'Terjadwal')
                  ->where('tanggal', '>=', now()->toDateString());
            })
            ->count();

        // Asesmen aktif terbaru (untuk progress card)
        $asesmenAktif = Asesmen::whereIn('pendaftaran_id', $pendaftaranPaid)
            ->where('status', 'berlangsung')
            ->with(['pendaftaran.skema', 'absensi'])
            ->latest()
            ->first();

        // Informasi terbaru
        $informasi = Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        return view('user.dashboard', compact(
            'skemaCount',
            'kompeten',
            'jadwalCount',
            'totalSertifikat',
            'dalamProses',
            'asesmenAktif',
            'informasi'
        ));
    }
}
