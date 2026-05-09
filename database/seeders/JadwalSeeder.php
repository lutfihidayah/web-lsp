<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Skema;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $skemas = Skema::all()->keyBy('nama');

        $jadwals = [
            [
                'skema_id' => $skemas['Junior Web Developer']->id ?? 1,
                'tanggal'  => '2026-06-10',
                'waktu'    => '08.00 - 16.00',
                'lokasi'   => 'Ruang A101',
                'asesor'   => 'Budi Santoso',
                'kuota'    => 25,
                'status'   => 'Selesai',
            ],
            [
                'skema_id' => $skemas['Digital Marketing Specialist']->id ?? 2,
                'tanggal'  => '2026-06-12',
                'waktu'    => '09.00 - 15.00',
                'lokasi'   => 'Ruang B202',
                'asesor'   => 'Rina Oktavia',
                'kuota'    => 20,
                'status'   => 'Selesai',
            ],
            [
                'skema_id' => $skemas['Network Administrator']->id ?? 4,
                'tanggal'  => '2026-06-15',
                'waktu'    => '08.00 - 17.00',
                'lokasi'   => 'Lab Jaringan',
                'asesor'   => 'Hendra Wijaya',
                'kuota'    => 18,
                'status'   => 'Berlangsung',
            ],
            [
                'skema_id' => $skemas['Administrasi Perkantoran']->id ?? 3,
                'tanggal'  => '2026-06-18',
                'waktu'    => '08.00 - 14.00',
                'lokasi'   => 'Ruang C303',
                'asesor'   => 'Anisa Rahmawati',
                'kuota'    => 30,
                'status'   => 'Terjadwal',
            ],
            [
                'skema_id' => $skemas['Graphic Designer']->id ?? 5,
                'tanggal'  => '2026-06-20',
                'waktu'    => '09.00 - 16.00',
                'lokasi'   => 'Lab Desain',
                'asesor'   => 'Sofa Azzahra',
                'kuota'    => 22,
                'status'   => 'Terjadwal',
            ],
            [
                'skema_id' => $skemas['Data Analyst']->id ?? 6,
                'tanggal'  => '2026-06-22',
                'waktu'    => '08.00 - 15.00',
                'lokasi'   => 'Ruang A102',
                'asesor'   => 'Dimas Mardiana',
                'kuota'    => 15,
                'status'   => 'Terjadwal',
            ],
            [
                'skema_id' => $skemas['UI/UX Designer']->id ?? 7,
                'tanggal'  => '2026-06-25',
                'waktu'    => '09.00 - 16.00',
                'lokasi'   => 'Lab Desain',
                'asesor'   => 'Lutfi Hidayah',
                'kuota'    => 19,
                'status'   => 'Terjadwal',
            ],
            [
                'skema_id' => $skemas['Software Engineer']->id ?? 9,
                'tanggal'  => '2026-06-27',
                'waktu'    => '08.00 - 17.00',
                'lokasi'   => 'Lab Komputer',
                'asesor'   => 'Budi Santoso',
                'kuota'    => 28,
                'status'   => 'Terjadwal',
            ],
            [
                'skema_id' => $skemas['Cyber Security']->id ?? 8,
                'tanggal'  => '2026-06-28',
                'waktu'    => '08.00 - 16.00',
                'lokasi'   => 'Lab Jaringan',
                'asesor'   => 'Hendra Wijaya',
                'kuota'    => 12,
                'status'   => 'Dibatalkan',
            ],
            [
                'skema_id' => $skemas['Data Analyst']->id ?? 6,
                'tanggal'  => '2026-06-30',
                'waktu'    => '09.00 - 15.00',
                'lokasi'   => 'Ruang B201',
                'asesor'   => 'Rina Oktavia',
                'kuota'    => 17,
                'status'   => 'Terjadwal',
            ],
        ];

        foreach ($jadwals as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
