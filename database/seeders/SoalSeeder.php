<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Skema;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        $soalData = [
            'Junior Web Developer' => [
                ['pertanyaan' => 'Apa kepanjangan dari HTML?', 'pilihan_a' => 'Hyper Text Markup Language', 'pilihan_b' => 'High Text Machine Language', 'pilihan_c' => 'Hyper Transfer Markup Language', 'pilihan_d' => 'Home Tool Markup Language', 'jawaban_benar' => 'a'],
                ['pertanyaan' => 'Tag HTML yang digunakan untuk membuat link adalah?', 'pilihan_a' => '<link>', 'pilihan_b' => '<a>', 'pilihan_c' => '<href>', 'pilihan_d' => '<url>', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'CSS digunakan untuk?', 'pilihan_a' => 'Membuat struktur halaman', 'pilihan_b' => 'Membuat logika program', 'pilihan_c' => 'Mengatur tampilan halaman', 'pilihan_d' => 'Mengelola database', 'jawaban_benar' => 'c'],
                ['pertanyaan' => 'Properti CSS untuk mengubah warna teks adalah?', 'pilihan_a' => 'text-color', 'pilihan_b' => 'font-color', 'pilihan_c' => 'color', 'pilihan_d' => 'text-style', 'jawaban_benar' => 'c'],
                ['pertanyaan' => 'JavaScript adalah bahasa pemrograman yang berjalan di?', 'pilihan_a' => 'Server saja', 'pilihan_b' => 'Browser saja', 'pilihan_c' => 'Database', 'pilihan_d' => 'Browser dan Server', 'jawaban_benar' => 'd'],
                ['pertanyaan' => 'Fungsi document.getElementById() digunakan untuk?', 'pilihan_a' => 'Membuat elemen baru', 'pilihan_b' => 'Menghapus elemen', 'pilihan_c' => 'Memilih elemen berdasarkan ID', 'pilihan_d' => 'Mengubah warna halaman', 'jawaban_benar' => 'c'],
                ['pertanyaan' => 'Apa itu responsive design?', 'pilihan_a' => 'Desain yang cepat', 'pilihan_b' => 'Desain yang menyesuaikan ukuran layar', 'pilihan_c' => 'Desain yang berwarna', 'pilihan_d' => 'Desain yang animatif', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'Tag HTML untuk menampilkan gambar adalah?', 'pilihan_a' => '<image>', 'pilihan_b' => '<pic>', 'pilihan_c' => '<img>', 'pilihan_d' => '<photo>', 'jawaban_benar' => 'c'],
                ['pertanyaan' => 'Apa fungsi dari tag <form> dalam HTML?', 'pilihan_a' => 'Menampilkan tabel', 'pilihan_b' => 'Membuat formulir input', 'pilihan_c' => 'Membuat navigasi', 'pilihan_d' => 'Menampilkan video', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'Framework CSS yang populer adalah?', 'pilihan_a' => 'React', 'pilihan_b' => 'Laravel', 'pilihan_c' => 'Bootstrap', 'pilihan_d' => 'Node.js', 'jawaban_benar' => 'c'],
            ],
            'Digital Marketing Specialist' => [
                ['pertanyaan' => 'Apa kepanjangan dari SEO?', 'pilihan_a' => 'Search Engine Optimization', 'pilihan_b' => 'Social Engine Operation', 'pilihan_c' => 'Search Email Optimization', 'pilihan_d' => 'Site Engine Optimizer', 'jawaban_benar' => 'a'],
                ['pertanyaan' => 'Platform media sosial mana yang paling efektif untuk B2B marketing?', 'pilihan_a' => 'TikTok', 'pilihan_b' => 'LinkedIn', 'pilihan_c' => 'Snapchat', 'pilihan_d' => 'Pinterest', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'CTR adalah singkatan dari?', 'pilihan_a' => 'Click Through Rate', 'pilihan_b' => 'Cost Through Revenue', 'pilihan_c' => 'Customer Target Rate', 'pilihan_d' => 'Content To Revenue', 'jawaban_benar' => 'a'],
                ['pertanyaan' => 'Apa itu bounce rate?', 'pilihan_a' => 'Jumlah pengunjung baru', 'pilihan_b' => 'Persentase pengunjung yang langsung meninggalkan situs', 'pilihan_c' => 'Kecepatan loading halaman', 'pilihan_d' => 'Jumlah klik iklan', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'Google Ads menggunakan model pembayaran?', 'pilihan_a' => 'Pay Per View', 'pilihan_b' => 'Pay Per Click', 'pilihan_c' => 'Pay Per Month', 'pilihan_d' => 'Pay Per User', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'Apa fungsi Google Analytics?', 'pilihan_a' => 'Membuat website', 'pilihan_b' => 'Mengirim email', 'pilihan_c' => 'Menganalisis trafik website', 'pilihan_d' => 'Membuat iklan', 'jawaban_benar' => 'c'],
                ['pertanyaan' => 'Content marketing bertujuan untuk?', 'pilihan_a' => 'Menjual langsung', 'pilihan_b' => 'Memberikan nilai melalui konten berkualitas', 'pilihan_c' => 'Mengirim spam', 'pilihan_d' => 'Membuat virus', 'jawaban_benar' => 'b'],
                ['pertanyaan' => 'KPI dalam marketing adalah?', 'pilihan_a' => 'Key Performance Indicator', 'pilihan_b' => 'Knowledge Process Integration', 'pilihan_c' => 'Key Product Information', 'pilihan_d' => 'Known Performance Index', 'jawaban_benar' => 'a'],
                ['pertanyaan' => 'Email marketing yang efektif harus memiliki?', 'pilihan_a' => 'Subject line menarik', 'pilihan_b' => 'Banyak gambar besar', 'pilihan_c' => 'Teks sangat panjang', 'pilihan_d' => 'Warna mencolok', 'jawaban_benar' => 'a'],
                ['pertanyaan' => 'Apa itu A/B Testing?', 'pilihan_a' => 'Tes kecepatan internet', 'pilihan_b' => 'Membandingkan dua versi untuk melihat mana yang lebih efektif', 'pilihan_c' => 'Tes keamanan website', 'pilihan_d' => 'Tes kompatibilitas browser', 'jawaban_benar' => 'b'],
            ],
        ];

        // Ambil semua skema, buat soal generik untuk skema yang tidak punya soal spesifik
        $skemas = Skema::all();
        foreach ($skemas as $skema) {
            if (isset($soalData[$skema->nama])) {
                foreach ($soalData[$skema->nama] as $soal) {
                    Soal::create(array_merge($soal, ['skema_id' => $skema->id]));
                }
            } else {
                // Buat 10 soal generik untuk skema yang belum punya soal spesifik
                for ($i = 1; $i <= 10; $i++) {
                    Soal::create([
                        'skema_id' => $skema->id,
                        'pertanyaan' => "Soal {$i} untuk skema {$skema->nama}: Apa yang dimaksud dengan kompetensi utama dalam bidang {$skema->kategori}?",
                        'pilihan_a' => 'Kemampuan dasar yang harus dikuasai',
                        'pilihan_b' => 'Kemampuan tambahan yang opsional',
                        'pilihan_c' => 'Kemampuan yang tidak relevan',
                        'pilihan_d' => 'Kemampuan yang sudah usang',
                        'jawaban_benar' => 'a',
                    ]);
                }
            }
        }
    }
}
