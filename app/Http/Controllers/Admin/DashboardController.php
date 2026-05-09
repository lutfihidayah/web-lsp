<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Skema;
use App\Models\Jadwal;
use App\Models\Hasil;
use App\Models\Informasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat Cards
        $totalPeserta   = Peserta::count();
        $pesertaAktif   = Peserta::whereIn('status', ['Verifikasi', 'Asesmen', 'Dalam Proses'])->count();
        $skemaAktif     = Skema::where('status', 'Aktif')->count();
        $jadwalBulanIni = Jadwal::whereMonth('tanggal', Carbon::now()->month)
                                ->whereYear('tanggal', Carbon::now()->year)
                                ->count();

        // Chart: Trend pendaftaran peserta per bulan (6 bulan terakhir)
        $trendLabels = [];
        $trendData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $date          = Carbon::now()->subMonths($i);
            $trendLabels[] = $date->format('M Y');
            $trendData[]   = Peserta::whereYear('created_at', $date->year)
                                    ->whereMonth('created_at', $date->month)
                                    ->count();
        }

        // Chart: Status Kompetensi
        $statusKompeten      = Hasil::where('hasil', 'Kompeten')->count();
        $statusBelumKompeten = Hasil::where('hasil', 'Belum Kompeten')->count();
        $statusDalamProses   = Hasil::where('hasil', 'Dalam Proses')->count();

        // Peserta terbaru
        $pesertaTerbaru = Peserta::with('skema')->latest()->take(5)->get();

        // Informasi terbaru
        $informasiTerbaru = Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalPeserta',
            'pesertaAktif',
            'skemaAktif',
            'jadwalBulanIni',
            'trendLabels',
            'trendData',
            'statusKompeten',
            'statusBelumKompeten',
            'statusDalamProses',
            'pesertaTerbaru',
            'informasiTerbaru'
        ));
    }
}