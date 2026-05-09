<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Jadwal;
use App\Models\Hasil;
use App\Models\Informasi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cari data peserta berdasarkan email user
        $peserta = Peserta::where('email', $user->email)->with(['skema', 'hasil'])->get();

        $skemaCount     = $peserta->count();
        $kompeten       = $peserta->filter(fn($p) => $p->status === 'Kompeten')->count();
        $jadwalCount    = Jadwal::where('status', 'Terjadwal')
                                ->where('tanggal', '>=', now()->toDateString())
                                ->count();
        $totalSertifikat = Hasil::where('hasil', 'Kompeten')
                                ->whereIn('peserta_id', $peserta->pluck('id'))
                                ->count();

        // Informasi terbaru
        $informasi = Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        return view('user.dashboard', compact(
            'skemaCount',
            'kompeten',
            'jadwalCount',
            'totalSertifikat',
            'informasi'
        ));
    }
}
