<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use App\Models\Informasi;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Skema;
use App\Models\Hasil;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->userDashboard($user);
    }

    private function adminDashboard()
    {
        // Stat Cards
        $totalPeserta   = Peserta::count();
        $pesertaAktif   = Peserta::whereIn('status', ['Verifikasi', 'Asesmen', 'Dalam Proses'])->count();
        $skemaAktif     = Skema::where('status', 'Aktif')->count();
        $jadwalBulanIni = Jadwal::whereMonth('tanggal', Carbon::now()->month)
                                ->whereYear('tanggal', Carbon::now()->year)
                                ->count();

        // Chart: Trend pendaftaran peserta per bulan (6 bulan terakhir) — 1 query, bukan 6
        $trendLabels   = [];
        $trendData     = [];
        $sixMonthsAgo  = Carbon::now()->subMonths(5)->startOfMonth();

        $driver = \Illuminate\Support\Facades\DB::getDriverName();
        if ($driver === 'pgsql') {
            $selectRaw = "to_char(created_at, 'YYYY-MM') as bulan, COUNT(*) as total";
        } elseif ($driver === 'sqlite') {
            $selectRaw = "strftime('%Y-%m', created_at) as bulan, COUNT(*) as total";
        } else {
            $selectRaw = "DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total";
        }

        $trendRaw = Peserta::selectRaw($selectRaw)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->pluck('total', 'bulan');

        for ($i = 5; $i >= 0; $i--) {
            $date          = Carbon::now()->subMonths($i);
            $key           = $date->format('Y-m');
            $trendLabels[] = $date->format('M Y');
            $trendData[]   = $trendRaw->get($key, 0);
        }

        // Chart: Status Kompetensi
        $statusKompeten      = Asesmen::where('status', 'lulus')->count();
        $statusBelumKompeten = Asesmen::where('status', 'tidak_lulus')->count();
        $statusDalamProses   = Asesmen::where('status', 'berlangsung')->count();

        // Peserta terbaru
        $pesertaTerbaru = Peserta::with('skema')->latest()->take(5)->get();

        // Informasi terbaru
        $informasiTerbaru = Informasi::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        return view('dashboard.index', compact(
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

    private function userDashboard($user)
    {
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

        return view('dashboard.index', compact(
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
