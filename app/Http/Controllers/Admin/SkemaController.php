<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
    public function index()
    {
        $skemas = Skema::withCount('peserta')->latest()->get();
        return view('admin.skema', compact('skemas'));
    }

    public function create()
    {
        return view('admin.skema-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'kategori'        => 'required|string|max:255',
            'durasi'          => 'required|string|max:100',
            'unit_kompetensi' => 'required|integer|min:1',
            'status'          => 'required|in:Aktif,Tidak Aktif',
            'deskripsi'       => 'nullable|string',
            'harga'           => 'required|integer|min:0',
        ]);

        Skema::create($request->all());
        return redirect()->route('admin.skema')->with('success', 'Skema berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $skema = Skema::findOrFail($id);
        return view('admin.skema-edit', compact('skema'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'kategori'        => 'required|string|max:255',
            'durasi'          => 'required|string|max:100',
            'unit_kompetensi' => 'required|integer|min:1',
            'status'          => 'required|in:Aktif,Tidak Aktif',
            'deskripsi'       => 'nullable|string',
            'harga'           => 'required|integer|min:0',
        ]);

        Skema::findOrFail($id)->update($request->all());
        return redirect()->route('admin.skema')->with('success', 'Skema berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Skema::findOrFail($id)->delete();
        return redirect()->route('admin.skema')->with('success', 'Skema berhasil dihapus!');
    }
}