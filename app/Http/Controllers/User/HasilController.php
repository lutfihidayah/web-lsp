<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;

class HasilController extends Controller
{
    public function index()
    {
        $asesmens = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereIn('status', ['lulus', 'tidak_lulus', 'berlangsung'])
            ->with(['pendaftaran.skema', 'pendaftaran.jadwal'])
            ->latest()
            ->get();

        $kompeten      = $asesmens->where('status', 'lulus')->count();
        $belumKompeten = $asesmens->where('status', 'tidak_lulus')->count();
        $dalamProses   = $asesmens->where('status', 'berlangsung')->count();

        return view('user.hasil', compact('asesmens', 'kompeten', 'belumKompeten', 'dalamProses'));
    }

    /**
     * Lihat sertifikat
     */
    public function downloadSertifikat($asesmenId)
    {
        $asesmen = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['pendaftaran.skema', 'pendaftaran.user'])
            ->where('status', 'lulus')
            ->findOrFail($asesmenId);

        return view('user.sertifikat', compact('asesmen'));
    }
}
