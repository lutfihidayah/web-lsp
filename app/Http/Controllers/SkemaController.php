<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
    /**
     * Admin: semua skema | User: hanya yang Aktif
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $skemas = Skema::withCount('peserta')->latest()->get();
        } else {
            $skemas = Skema::where('status', 'Aktif')
                ->withCount('peserta')
                ->latest()
                ->get();
        }

        return view('skema.index', compact('skemas'));
    }

    /**
     * Admin only
     */
    public function create()
    {
        return view('skema.create');
    }

    /**
     * Admin only
     */
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
            'passing_grade'   => 'required|integer|min:0|max:100',
        ]);

        Skema::create($request->validated());
        return redirect()->route('skema.index')->with('success', 'Skema berhasil ditambahkan!');
    }

    /**
     * User: detail skema | Admin: detail juga bisa
     */
    public function show($id)
    {
        $skema = Skema::withCount('peserta')->findOrFail($id);
        return view('skema.show', compact('skema'));
    }

    /**
     * Admin only
     */
    public function edit($id)
    {
        $skema = Skema::findOrFail($id);
        return view('skema.edit', compact('skema'));
    }

    /**
     * Admin only
     */
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
            'passing_grade'   => 'required|integer|min:0|max:100',
        ]);

        Skema::findOrFail($id)->update($request->validated());
        return redirect()->route('skema.index')->with('success', 'Skema berhasil diperbarui!');
    }

    /**
     * Admin only
     */
    public function destroy($id)
    {
        Skema::findOrFail($id)->delete();
        return redirect()->route('skema.index')->with('success', 'Skema berhasil dihapus!');
    }
}
