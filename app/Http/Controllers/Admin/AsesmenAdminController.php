<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AsesmenAdminController extends Controller
{
    /**
     * Monitor semua asesmen peserta
     */
    public function index(Request $request)
    {
        $query = Asesmen::with(['pendaftaran.skema', 'pendaftaran.user', 'absensi']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('pendaftaran.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $asesmens = $query->latest()->paginate(15)->withQueryString();

        $totalBerlangsung = Asesmen::where('status', 'berlangsung')->count();
        $totalLulus = Asesmen::where('status', 'lulus')->count();
        $totalTidakLulus = Asesmen::where('status', 'tidak_lulus')->count();

        return view('admin.asesmen', compact('asesmens', 'totalBerlangsung', 'totalLulus', 'totalTidakLulus'));
    }

    /**
     * Detail progress 1 peserta
     */
    public function show($id)
    {
        $asesmen = Asesmen::with([
            'pendaftaran.skema',
            'pendaftaran.user',
            'pendaftaran.jadwal',
            'absensi',
            'quizJawaban.soal',
        ])->findOrFail($id);

        return view('admin.asesmen-show', compact('asesmen'));
    }

    /**
     * Admin konfirmasi kehadiran peserta
     */
    public function konfirmasiHadir($absensiId)
    {
        $absensi = Absensi::findOrFail($absensiId);

        if ($absensi->status !== 'hadir') {
            return back()->with('error', 'Peserta belum menandai kehadiran untuk pertemuan ini.');
        }

        $absensi->update(['dikonfirmasi_oleh' => 'admin']);

        return back()->with('success', 'Kehadiran pertemuan ke-' . $absensi->pertemuan_ke . ' berhasil dikonfirmasi.');
    }

    /**
     * Admin konfirmasi semua kehadiran sekaligus
     */
    public function konfirmasiSemua($asesmenId)
    {
        $asesmen = Asesmen::findOrFail($asesmenId);

        $updated = $asesmen->absensi()
            ->where('status', 'hadir')
            ->where(function ($q) {
                $q->whereNull('dikonfirmasi_oleh')
                  ->orWhere('dikonfirmasi_oleh', 'user');
            })
            ->update(['dikonfirmasi_oleh' => 'admin']);

        return back()->with('success', $updated . ' absensi berhasil dikonfirmasi.');
    }
}
