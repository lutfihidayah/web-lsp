<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hasil;
use App\Models\Peserta;
use App\Models\Jadwal;

class HasilSeeder extends Seeder
{
    public function run(): void
    {
        $peserta = Peserta::all();
        $jadwals = Jadwal::where('status', 'Selesai')->get();

        if ($peserta->isEmpty() || $jadwals->isEmpty()) {
            return;
        }

        $hasilData = [
            [
                'peserta_id'   => $peserta->where('email', 'lutfi@gmail.com')->first()?->id ?? $peserta[0]->id,
                'jadwal_id'    => $jadwals[0]->id,
                'asesor'       => 'Budi Santoso',
                'nilai'        => 85,
                'hasil'        => 'Kompeten',
                'no_sertifikat'=> 'LSP-001-2026',
            ],
            [
                'peserta_id'   => $peserta->where('email', 'sofa@gmail.com')->first()?->id ?? $peserta[1]->id,
                'jadwal_id'    => $jadwals[0]->id,
                'asesor'       => 'Hendra Wijaya',
                'nilai'        => 78,
                'hasil'        => 'Kompeten',
                'no_sertifikat'=> 'LSP-002-2026',
            ],
            [
                'peserta_id'   => $peserta->where('email', 'dimas@gmail.com')->first()?->id ?? $peserta[2]->id,
                'jadwal_id'    => $jadwals[1]->id,
                'asesor'       => 'Anisa Rahmawati',
                'nilai'        => 55,
                'hasil'        => 'Belum Kompeten',
                'no_sertifikat'=> null,
            ],
            [
                'peserta_id'   => $peserta->where('email', 'masud@gmail.com')->first()?->id ?? $peserta[3]->id,
                'jadwal_id'    => $jadwals[1]->id,
                'asesor'       => 'Rina Oktavia',
                'nilai'        => 90,
                'hasil'        => 'Kompeten',
                'no_sertifikat'=> 'LSP-003-2026',
            ],
            [
                'peserta_id'   => $peserta->where('email', 'rina@gmail.com')->first()?->id ?? $peserta[4]->id,
                'jadwal_id'    => $jadwals[0]->id,
                'asesor'       => 'Budi Santoso',
                'nilai'        => null,
                'hasil'        => 'Dalam Proses',
                'no_sertifikat'=> null,
            ],
            [
                'peserta_id'   => $peserta->where('email', 'budi@gmail.com')->first()?->id ?? $peserta[5]->id,
                'jadwal_id'    => $jadwals[1]->id,
                'asesor'       => 'Lutfi Hidayah',
                'nilai'        => 88,
                'hasil'        => 'Kompeten',
                'no_sertifikat'=> 'LSP-004-2026',
            ],
            [
                'peserta_id'   => $peserta->where('email', 'anisa@gmail.com')->first()?->id ?? $peserta[6]->id,
                'jadwal_id'    => $jadwals[0]->id,
                'asesor'       => 'Sofa Azzahra',
                'nilai'        => null,
                'hasil'        => 'Dalam Proses',
                'no_sertifikat'=> null,
            ],
            [
                'peserta_id'   => $peserta->where('email', 'hendra@gmail.com')->first()?->id ?? $peserta[7]->id,
                'jadwal_id'    => $jadwals[1]->id,
                'asesor'       => 'Dimas Mardiana',
                'nilai'        => 60,
                'hasil'        => 'Belum Kompeten',
                'no_sertifikat'=> null,
            ],
        ];

        foreach ($hasilData as $h) {
            Hasil::create($h);
        }
    }
}
