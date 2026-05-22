<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = Peserta::with('skema')->latest()->get();
        $skemas  = Skema::where('status', 'Aktif')->get();
        return view('peserta.index', compact('peserta', 'skemas'));
    }

    public function create()
    {
        $skemas = Skema::where('status', 'Aktif')->get();
        return view('peserta.create', compact('skemas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email',
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string',
            'skema_id'   => 'required|exists:skema,id',
            'status'     => 'required|in:Verifikasi,Asesmen,Kompeten,Belum Kompeten,Dalam Proses',
        ]);

        // Check if user is already a peserta for the same skema
        $existingUser = User::where('email', $validated['email'])->first();
        if ($existingUser) {
            $alreadyPeserta = Peserta::where('user_id', $existingUser->id)
                ->where('skema_id', $validated['skema_id'])
                ->exists();
            if ($alreadyPeserta) {
                return back()->withErrors(['email' => 'Peserta dengan email ini sudah terdaftar di skema yang sama.'])->withInput();
            }
        }

        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['nama'],
                'password' => bcrypt('password'),
                'role' => 'user',
                'status' => 'aktif',
                'no_telepon' => $validated['no_telepon'] ?? '-',
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update([
                'name' => $validated['nama'],
                'no_telepon' => $validated['no_telepon'] ?? $user->no_telepon,
            ]);
        }

        Peserta::create([
            'user_id'  => $user->id,
            'alamat'   => $validated['alamat'],
            'skema_id' => $validated['skema_id'],
            'status'   => $validated['status'],
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $peserta = Peserta::findOrFail($id);
        $skemas  = Skema::where('status', 'Aktif')->get();
        return view('peserta.edit', compact('peserta', 'skemas'));
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $user = $peserta->user;

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . ($user ? $user->id : 0),
            'no_telepon' => 'nullable|string|max:20',
            'alamat'     => 'nullable|string',
            'skema_id'   => 'required|exists:skema,id',
            'status'     => 'required|in:Verifikasi,Asesmen,Kompeten,Belum Kompeten,Dalam Proses',
        ]);

        if ($user) {
            $alreadyPeserta = Peserta::where('user_id', $user->id)
                ->where('skema_id', $validated['skema_id'])
                ->where('id', '!=', $peserta->id)
                ->exists();
            if ($alreadyPeserta) {
                return back()->withErrors(['email' => 'Peserta dengan email ini sudah terdaftar di skema yang sama.'])->withInput();
            }

            $user->update([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        }

        $peserta->update([
            'alamat'   => $validated['alamat'],
            'skema_id' => $validated['skema_id'],
            'status'   => $validated['status'],
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Peserta::findOrFail($id)->delete();
        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus!');
    }
}
