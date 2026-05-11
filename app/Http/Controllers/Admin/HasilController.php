<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $asesmens = Asesmen::with(['pendaftaran.user', 'pendaftaran.skema', 'pendaftaran.jadwal'])
            ->latest()
            ->get();

        $totalKompeten       = $asesmens->where('status', 'lulus')->count();
        $totalBelumKompeten  = $asesmens->where('status', 'tidak_lulus')->count();
        $totalDalamProses    = $asesmens->where('status', 'berlangsung')->count();

        return view('admin.hasil', compact('asesmens', 'totalKompeten', 'totalBelumKompeten', 'totalDalamProses'));
    }

    /**
     * Hapus record asesmen (jika diperlukan)
     */
    public function destroy($id)
    {
        Asesmen::findOrFail($id)->delete();
        return redirect()->route('admin.hasil')->with('success', 'Data hasil asesmen berhasil dihapus!');
    }
}