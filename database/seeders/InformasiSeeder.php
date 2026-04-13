<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Informasi;

class InformasiSeeder extends Seeder
{
    public function run(): void
    {
        $informasi = [
            ['judul' => 'Pembukaan Pendaftaran Sertifikasi Batch Januari 2026', 'kategori' => 'Pengumuman', 'isi' => 'LSP Profesional membuka pendaftaran untuk sertifikasi batch Januari 2026.', 'penulis' => 'Admin LSP', 'dilihat' => 1200, 'status' => 'Dipublikasikan'],
            ['judul' => 'Kerjasama dengan Industri untuk Peningkatan Kompetensi', 'kategori' => 'Kerjasama', 'isi' => 'LSP menjalin kerjasama strategis dengan berbagai perusahaan teknologi.', 'penulis' => 'Admin LSP', 'dilihat' => 876, 'status' => 'Dipublikasikan'],
            ['judul' => 'Tips Sukses Menghadapi Uji Kompetensi', 'kategori' => 'Tips', 'isi' => 'Panduan lengkap persiapan menghadapi uji kompetensi dari para asesor.', 'penulis' => 'Admin LSP', 'dilihat' => 2100, 'status' => 'Dipublikasikan'],
            ['judul' => 'Peluncuran Skema Sertifikasi Baru 2025', 'kategori' => 'Berita', 'isi' => 'LSP Profesional meluncurkan skema sertifikasi baru untuk tahun 2025.', 'penulis' => 'Admin LSP', 'dilihat' => 654, 'status' => 'Dipublikasikan'],
            ['judul' => 'Rencana Pembukaan Batch Baru Februari 2026', 'kategori' => 'Pengumuman', 'isi' => 'Informasi terkait rencana pembukaan batch baru Februari 2026.', 'penulis' => 'Admin LSP', 'dilihat' => 0, 'status' => 'Draft'],
        ];

        foreach ($informasi as $i) {
            Informasi::create($i);
        }
    }
}