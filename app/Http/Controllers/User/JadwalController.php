<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil jadwal_id dari Pendaftaran yang sudah PAID milik user ini
        $jadwalIds = Pendaftaran::where('user_id', $user->id)
            ->where('status', 'paid')
            ->whereNotNull('jadwal_id')
            ->pluck('jadwal_id')
            ->unique()
            ->filter();

        // Ambil data jadwal
        $jadwals = Jadwal::with('skema')
            ->whereIn('id', $jadwalIds)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Jadwal mendatang (belum lewat, masih Terjadwal)
        $jadwalMendatang = $jadwals->filter(function ($j) {
            return $j->status === 'Terjadwal'
                && Carbon::parse($j->tanggal)->isFuture();
        })->take(3);

        return view('user.jadwal', compact('jadwals', 'jadwalMendatang'));
    }
}
