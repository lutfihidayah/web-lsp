<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()->get();
        return view('informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi'      => 'required|string',
            'penulis'  => 'nullable|string|max:100',
            'status'   => 'required|in:Dipublikasikan,Draft',
        ]);

        Informasi::create([
            'judul'    => $request->judul,
            'kategori' => $request->kategori,
            'isi'      => $request->isi,
            'penulis'  => $request->penulis ?? 'Admin LSP',
            'dilihat'  => 0,
            'status'   => $request->status,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'isi'      => 'required|string',
            'penulis'  => 'nullable|string|max:100',
            'status'   => 'required|in:Dipublikasikan,Draft',
        ]);

        Informasi::findOrFail($id)->update([
            'judul'    => $request->judul,
            'kategori' => $request->kategori,
            'isi'      => $request->isi,
            'penulis'  => $request->penulis ?? 'Admin LSP',
            'status'   => $request->status,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)->delete();
        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus!');
    }
}
