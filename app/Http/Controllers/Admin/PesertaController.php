<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Skema;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = Peserta::with('skema')->latest()->get();
        return view('admin.peserta', compact('peserta'));
    }

    public function create()
    {
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('admin.peserta-create', compact('skemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:peserta,email',
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string',
            'skema_id'   => 'required|exists:skema,id',
            'status'     => 'required|in:Verifikasi,Asesmen,Kompeten,Belum Kompeten,Dalam Proses',
        ]);

        Peserta::create($request->all());

        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Peserta::findOrFail($id)->delete();
        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil dihapus!');
    }
}