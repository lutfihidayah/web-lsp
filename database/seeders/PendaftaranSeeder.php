<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Skema;
use App\Models\Jadwal;
use App\Models\Peserta;
use App\Models\Pendaftaran;
use App\Models\Asesmen;
use App\Models\Absensi;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dengan role 'user' (bukan admin)
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            $this->command->warn('Tidak ada user ditemukan. Buat user dulu via register.');
            return;
        }

        $skemas = Skema::where('status', 'Aktif')->get();
        $jadwals = Jadwal::where('status', 'Terjadwal')->get();

        foreach ($users as $user) {
            // Ambil 2 skema secara acak untuk setiap user
            $selectedSkemas = $skemas->random(min(2, $skemas->count()));

            foreach ($selectedSkemas as $skema) {
                // Cek sudah ada pendaftaran belum
                $exists = Pendaftaran::where('user_id', $user->id)
                    ->where('skema_id', $skema->id)
                    ->exists();

                if ($exists) continue;

                // Cari jadwal yang sesuai skema ini
                $jadwal = $jadwals->where('skema_id', $skema->id)->first();

                // Buat pendaftaran dengan status paid
                $pendaftaran = Pendaftaran::create([
                    'user_id'      => $user->id,
                    'skema_id'     => $skema->id,
                    'jadwal_id'    => $jadwal?->id,
                    'order_id'     => 'LSP-SEED-' . time() . '-' . $user->id . '-' . $skema->id,
                    'amount'       => $skema->harga ?? 1500000,
                    'status'       => 'paid',
                    'payment_type' => 'seeder',
                    'paid_at'      => now(),
                ]);

                // Buat record peserta
                Peserta::firstOrCreate(
                    ['email' => $user->email, 'skema_id' => $skema->id],
                    [
                        'nama'       => $user->name,
                        'no_telepon' => $user->no_telepon ?? '-',
                        'alamat'     => '-',
                        'status'     => 'Dalam Proses',
                    ]
                );

                // Parse durasi skema
                preg_match('/(\d+)/', $skema->durasi ?? '1', $matches);
                $jumlahPertemuan = (int) ($matches[1] ?? 1);
                if ($jumlahPertemuan < 1) $jumlahPertemuan = 1;

                // Buat asesmen
                $asesmen = Asesmen::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'status'         => 'berlangsung',
                ]);

                // Buat absensi per pertemuan
                $startDate = $jadwal
                    ? Carbon::parse($jadwal->tanggal)
                    : now()->addDays(7);

                for ($i = 1; $i <= $jumlahPertemuan; $i++) {
                    Absensi::create([
                        'asesmen_id'   => $asesmen->id,
                        'pertemuan_ke' => $i,
                        'tanggal'      => $startDate->copy()->addDays($i - 1),
                        'status'       => 'belum',
                    ]);
                }
            }
        }

        $this->command->info('PendaftaranSeeder berhasil! ' . $users->count() . ' user dibuatkan pendaftaran.');
    }
}