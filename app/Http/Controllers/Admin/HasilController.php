<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Peserta;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $hasil               = Hasil::with(['peserta.skema', 'jadwal.skema'])->latest()->get();
        $totalKompeten       = Hasil::where('hasil', 'Kompeten')->count();
        $totalBelumKompeten  = Hasil::where('hasil', 'Belum Kompeten')->count();
        $totalDalamProses    = Hasil::where('hasil', 'Dalam Proses')->count();

        return view('admin.hasil', compact('hasil', 'totalKompeten', 'totalBelumKompeten', 'totalDalamProses'));
    }

    public function create()
    {
        $peserta = Peserta::orderBy('nama')->get();
        $jadwals = Jadwal::with('skema')->latest('tanggal')->get();
        return view('admin.hasil-create', compact('peserta', 'jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_id'    => 'required|exists:peserta,id',
            'jadwal_id'     => 'required|exists:jadwal,id',
            'asesor'        => 'required|string|max:255',
            'nilai'         => 'nullable|integer|min:0|max:100',
            'hasil'         => 'required|in:Kompeten,Belum Kompeten,Dalam Proses',
            'no_sertifikat' => 'nullable|string|max:100',
        ]);

        Hasil::create($request->all());
        return redirect()->route('admin.hasil')->with('success', 'Hasil sertifikasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $h       = Hasil::findOrFail($id);
        $peserta = Peserta::orderBy('nama')->get();
        $jadwals = Jadwal::with('skema')->latest('tanggal')->get();
        return view('admin.hasil-edit', compact('h', 'peserta', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peserta_id'    => 'required|exists:peserta,id',
            'jadwal_id'     => 'required|exists:jadwal,id',
            'asesor'        => 'required|string|max:255',
            'nilai'         => 'nullable|integer|min:0|max:100',
            'hasil'         => 'required|in:Kompeten,Belum Kompeten,Dalam Proses',
            'no_sertifikat' => 'nullable|string|max:100',
        ]);

        Hasil::findOrFail($id)->update($request->all());
        return redirect()->route('admin.hasil')->with('success', 'Hasil sertifikasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Hasil::findOrFail($id)->delete();
        return redirect()->route('admin.hasil')->with('success', 'Hasil sertifikasi berhasil dihapus!');
    }
}