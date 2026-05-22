<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    /**
     * Admin: semua hasil asesmen | User: hasil milik sendiri
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $asesmens = Asesmen::with(['pendaftaran.user', 'pendaftaran.skema', 'pendaftaran.jadwal'])
                ->latest()
                ->get();

            $totalKompeten      = $asesmens->where('status', 'lulus')->count();
            $totalBelumKompeten = $asesmens->where('status', 'tidak_lulus')->count();
            $totalDalamProses   = $asesmens->where('status', 'berlangsung')->count();

            $kompeten      = $totalKompeten;
            $belumKompeten = $totalBelumKompeten;
            $dalamProses   = $totalDalamProses;

            return view('hasil.index', compact('asesmens', 'totalKompeten', 'totalBelumKompeten', 'totalDalamProses', 'kompeten', 'belumKompeten', 'dalamProses'));
        }

        // User: hanya hasil milik sendiri
        $asesmens = Asesmen::whereHas('pendaftaran', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereIn('status', ['lulus', 'tidak_lulus', 'berlangsung'])
            ->with(['pendaftaran.skema', 'pendaftaran.jadwal'])
            ->latest()
            ->get();

        $kompeten      = $asesmens->where('status', 'lulus')->count();
        $belumKompeten = $asesmens->where('status', 'tidak_lulus')->count();
        $dalamProses   = $asesmens->where('status', 'berlangsung')->count();

        $totalKompeten      = $kompeten;
        $totalBelumKompeten = $belumKompeten;
        $totalDalamProses   = $dalamProses;

        return view('hasil.index', compact('asesmens', 'totalKompeten', 'totalBelumKompeten', 'totalDalamProses', 'kompeten', 'belumKompeten', 'dalamProses'));
    }

    /**
     * Admin: create hasil
     */
    public function create()
    {
        return view('hasil.create');
    }

    /**
     * Admin: store hasil
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status'         => 'required|in:lulus,tidak_lulus,berlangsung',
            'nilai_quiz'     => 'nullable|numeric',
            'no_sertifikat'  => 'nullable|string',
        ]);

        Asesmen::create($validated);

        return redirect()->route('hasil.index')->with('success', 'Hasil berhasil ditambahkan!');
    }

    /**
     * Admin: edit hasil
     */
    public function edit($id)
    {
        $asesmen = Asesmen::findOrFail($id);
        return view('hasil.edit', compact('asesmen'));
    }

    /**
     * Admin: update hasil
     */
    public function update(Request $request, $id)
    {
        $asesmen = Asesmen::findOrFail($id);

        $validated = $request->validate([
            'status'        => 'required|in:lulus,tidak_lulus,berlangsung',
            'nilai_quiz'    => 'nullable|numeric',
            'no_sertifikat' => 'nullable|string',
        ]);

        $asesmen->update($validated);

        return redirect()->route('hasil.index')->with('success', 'Hasil berhasil diperbarui!');
    }

    /**
     * Admin: hapus hasil
     */
    public function destroy($id)
    {
        Asesmen::findOrFail($id)->delete();
        return redirect()->route('hasil.index')->with('success', 'Data hasil asesmen berhasil dihapus!');
    }

    /**
     * Admin: sertifikat peserta manapun | User: sertifikat milik sendiri
     */
    public function sertifikat($asesmenId)
    {
        $user  = auth()->user();
        $query = Asesmen::with(['pendaftaran.skema', 'pendaftaran.user'])
            ->where('status', 'lulus');

        // Admin boleh melihat sertifikat peserta manapun untuk verifikasi dan cetak fisik
        if ($user->role !== 'admin') {
            $query->whereHas('pendaftaran', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $asesmen = $query->findOrFail($asesmenId);

        return view('sertifikat.show', compact('asesmen'));
    }
}
