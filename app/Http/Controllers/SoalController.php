<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Skema;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $skemas = Skema::withCount('soals')->latest()->get();

        $query = Soal::with('skema');

        if ($request->filled('skema_id')) {
            $query->where('skema_id', $request->skema_id);
        }

        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        $soals = $query->latest()->paginate(15)->withQueryString();

        return view('soal.index', compact('soals', 'skemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skemas = Skema::latest()->get();
        return view('soal.create', compact('skemas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'skema_id'      => 'required|exists:skema,id',
            'pertanyaan'    => 'required|string',
            'pilihan_a'     => 'required|string|max:255',
            'pilihan_b'     => 'required|string|max:255',
            'pilihan_c'     => 'required|string|max:255',
            'pilihan_d'     => 'required|string|max:255',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        Soal::create($validated);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $skemas = Skema::latest()->get();
        return view('soal.edit', compact('soal', 'skemas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'skema_id'      => 'required|exists:skema,id',
            'pertanyaan'    => 'required|string',
            'pilihan_a'     => 'required|string|max:255',
            'pilihan_b'     => 'required|string|max:255',
            'pilihan_c'     => 'required|string|max:255',
            'pilihan_d'     => 'required|string|max:255',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        $soal = Soal::findOrFail($id);
        $soal->update($validated);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return redirect()->route('soal.index')->with('success', 'Soal berhasil dihapus!');
    }
}
