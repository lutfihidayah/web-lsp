<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()->get();
        return view('admin.informasi', compact('informasi'));
    }

    public function create()
    {
        return view('admin.informasi-create');
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

        return redirect()->route('admin.informasi')->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('admin.informasi-edit', compact('informasi'));
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

        return redirect()->route('admin.informasi')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)->delete();
        return redirect()->route('admin.informasi')->with('success', 'Informasi berhasil dihapus!');
    }
}