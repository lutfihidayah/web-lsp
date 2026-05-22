<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Skema;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Admin: semua jadwal | User: jadwal yang sudah dibayar
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $jadwals         = Jadwal::with('skema')->latest('tanggal')->get();
            $skemas          = Skema::where('status', 'Aktif')->get();
            $jadwalMendatang = collect();
        } else {
            $jadwalIds = Pendaftaran::where('user_id', $user->id)
                ->where('status', 'paid')
                ->whereNotNull('jadwal_id')
                ->pluck('jadwal_id')
                ->unique()
                ->filter();

            $jadwals = Jadwal::with('skema')
                ->whereIn('id', $jadwalIds)
                ->orderBy('tanggal', 'asc')
                ->get();

            $jadwalMendatang = $jadwals->filter(function ($j) {
                return $j->status === 'Terjadwal'
                    && Carbon::parse($j->tanggal)->isFuture();
            })->take(3);

            $skemas = collect();
        }

        return view('jadwal.index', compact('jadwals', 'jadwalMendatang', 'skemas'));
    }

    /**
     * Admin only
     */
    public function create()
    {
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('jadwal.create', compact('skemas'));
    }

    /**
     * Admin only
     */
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
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Admin only
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('jadwal.edit', compact('jadwal', 'skemas'));
    }

    /**
     * Admin only
     */
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
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Admin only
     */
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
