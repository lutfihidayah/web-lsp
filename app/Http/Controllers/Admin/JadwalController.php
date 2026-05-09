<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Skema;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('skema')->latest('tanggal')->get();
        return view('admin.jadwal', compact('jadwals'));
    }

    public function create()
    {
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('admin.jadwal-create', compact('skemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema,id',
            'tanggal'  => 'required|date',
            'waktu'    => 'required|string|max:50',
            'lokasi'   => 'required|string|max:255',
            'asesor'   => 'required|string|max:255',
            'kuota'    => 'required|integer|min:1',
            'status'   => 'required|in:Terjadwal,Berlangsung,Selesai,Dibatalkan',
        ]);

        Jadwal::create($request->all());
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('admin.jadwal-edit', compact('jadwal', 'skemas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema,id',
            'tanggal'  => 'required|date',
            'waktu'    => 'required|string|max:50',
            'lokasi'   => 'required|string|max:255',
            'asesor'   => 'required|string|max:255',
            'kuota'    => 'required|integer|min:1',
            'status'   => 'required|in:Terjadwal,Berlangsung,Selesai,Dibatalkan',
        ]);

        Jadwal::findOrFail($id)->update($request->all());
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}