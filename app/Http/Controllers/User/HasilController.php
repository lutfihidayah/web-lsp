<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Peserta;

class HasilController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil hanya peserta yang emailnya sama dengan user login
        $pesertaIds = Peserta::where('email', $user->email)->pluck('id');

        // Hanya tampilkan hasil milik user ini saja
        $hasil = Hasil::with(['peserta.skema', 'jadwal.skema'])
                      ->whereIn('peserta_id', $pesertaIds)
                      ->latest()
                      ->get();

        $kompeten      = $hasil->where('hasil', 'Kompeten')->count();
        $belumKompeten = $hasil->where('hasil', 'Belum Kompeten')->count();
        $dalamProses   = $hasil->where('hasil', 'Dalam Proses')->count();

        return view('user.hasil', compact('hasil', 'kompeten', 'belumKompeten', 'dalamProses'));
    }

    /**
     * Download sertifikat PDF (generate on-the-fly)
     */
    public function downloadSertifikat($hasilId)
    {
        $user       = auth()->user();
        $pesertaIds = Peserta::where('email', $user->email)->pluck('id');

        $hasil = Hasil::with(['peserta.skema', 'jadwal'])
                      ->whereIn('peserta_id', $pesertaIds)
                      ->where('id', $hasilId)
                      ->where('hasil', 'Kompeten')
                      ->firstOrFail();

        return view('user.sertifikat', compact('hasil'));
    }
}
