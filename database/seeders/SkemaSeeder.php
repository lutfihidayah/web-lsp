<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skema;

class SkemaSeeder extends Seeder
{
    public function run(): void
    {
        $skemas = [
            ['nama' => 'Junior Web Developer', 'kategori' => 'Teknologi Informasi', 'durasi' => '2-3 Hari', 'unit_kompetensi' => 8, 'status' => 'Aktif', 'deskripsi' => 'Kompetensi dalam membangun website dengan HTML, CSS, dan JavaScript.'],
            ['nama' => 'Digital Marketing Specialist', 'kategori' => 'Pemasaran Digital', 'durasi' => '2 Hari', 'unit_kompetensi' => 6, 'status' => 'Aktif', 'deskripsi' => 'Strategi pemasaran digital, SEO, dan manajemen media sosial.'],
            ['nama' => 'Administrasi Perkantoran', 'kategori' => 'Administrasi', 'durasi' => '5 Hari', 'unit_kompetensi' => 10, 'status' => 'Aktif', 'deskripsi' => 'Kompetensi administrasi perkantoran secara profesional.'],
            ['nama' => 'Network Administrator', 'kategori' => 'Teknologi Informasi', 'durasi' => '3 Hari', 'unit_kompetensi' => 12, 'status' => 'Aktif', 'deskripsi' => 'Pengelolaan dan pemeliharaan infrastruktur jaringan komputer.'],
            ['nama' => 'Graphic Designer', 'kategori' => 'Desain', 'durasi' => '2 Hari', 'unit_kompetensi' => 7, 'status' => 'Aktif', 'deskripsi' => 'Desain grafis, branding, dan pembuatan konten visual.'],
            ['nama' => 'Data Analyst', 'kategori' => 'Teknologi Informasi', 'durasi' => '3 Hari', 'unit_kompetensi' => 10, 'status' => 'Aktif', 'deskripsi' => 'Analisis data, visualisasi, dan pengambilan keputusan berbasis data.'],
            ['nama' => 'UI/UX Designer', 'kategori' => 'Desain', 'durasi' => '3 Hari', 'unit_kompetensi' => 9, 'status' => 'Aktif', 'deskripsi' => 'Desain antarmuka dan pengalaman pengguna yang optimal.'],
            ['nama' => 'Cyber Security', 'kategori' => 'Teknologi Informasi', 'durasi' => '4 Hari', 'unit_kompetensi' => 14, 'status' => 'Tidak Aktif', 'deskripsi' => 'Keamanan sistem dan jaringan komputer.'],
            ['nama' => 'Software Engineer', 'kategori' => 'Teknologi Informasi', 'durasi' => '4 Hari', 'unit_kompetensi' => 12, 'status' => 'Aktif', 'deskripsi' => 'Pengembangan perangkat lunak secara profesional.'],
            ['nama' => 'Administrasi Keuangan', 'kategori' => 'Administrasi', 'durasi' => '3 Hari', 'unit_kompetensi' => 8, 'status' => 'Aktif', 'deskripsi' => 'Pengelolaan keuangan dan akuntansi perkantoran.'],
        ];

        foreach ($skemas as $skema) {
            Skema::create($skema);
        }
    }
}