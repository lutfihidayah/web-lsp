<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peserta;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $peserta = [
            ['nama' => 'Lutfi Hidayah', 'email' => 'lutfi@gmail.com', 'no_telepon' => '081234567890', 'alamat' => 'Kuningan, Jawa Barat', 'skema_id' => 1, 'status' => 'Verifikasi'],
            ['nama' => 'Sofa Azzahra', 'email' => 'sofa@gmail.com', 'no_telepon' => '081234567891', 'alamat' => 'Bandung, Jawa Barat', 'skema_id' => 4, 'status' => 'Asesmen'],
            ['nama' => 'Dimas Mardiana', 'email' => 'dimas@gmail.com', 'no_telepon' => '081234567892', 'alamat' => 'Jakarta Selatan', 'skema_id' => 7, 'status' => 'Belum Kompeten'],
            ['nama' => "Mas'ud", 'email' => 'masud@gmail.com', 'no_telepon' => '081234567893', 'alamat' => 'Cirebon, Jawa Barat', 'skema_id' => 3, 'status' => 'Kompeten'],
            ['nama' => 'Rina Oktavia', 'email' => 'rina@gmail.com', 'no_telepon' => '081234567894', 'alamat' => 'Surabaya, Jawa Timur', 'skema_id' => 2, 'status' => 'Dalam Proses'],
            ['nama' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'no_telepon' => '081234567895', 'alamat' => 'Yogyakarta', 'skema_id' => 6, 'status' => 'Kompeten'],
            ['nama' => 'Anisa Rahmawati', 'email' => 'anisa@gmail.com', 'no_telepon' => '081234567896', 'alamat' => 'Semarang, Jawa Tengah', 'skema_id' => 1, 'status' => 'Verifikasi'],
            ['nama' => 'Hendra Wijaya', 'email' => 'hendra@gmail.com', 'no_telepon' => '081234567897', 'alamat' => 'Medan, Sumatera Utara', 'skema_id' => 5, 'status' => 'Asesmen'],
        ];

        foreach ($peserta as $p) {
            Peserta::create($p);
        }
    }
}