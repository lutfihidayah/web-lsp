<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm px-8 py-4 flex items-center justify-between">
    <a href="/" class="text-[#1e3a6e] font-bold text-xl">LSP <span class="text-orange-400">Profesional</span></a>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
        <a href="#beranda" class="hover:text-[#1e3a6e]">Beranda</a>
        <a href="#tentang" class="hover:text-[#1e3a6e]">Tentang LSP</a>
        <a href="#skema" class="hover:text-[#1e3a6e]">Skema</a>
        <a href="#alur" class="hover:text-[#1e3a6e]">Alur</a>
        <a href="#informasi" class="hover:text-[#1e3a6e]">Informasi</a>
        <a href="#kontak" class="hover:text-[#1e3a6e]">Kontak</a>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}" class="px-5 py-2 border border-[#1e3a6e] text-[#1e3a6e] rounded-lg text-sm font-medium hover:bg-gray-50">Masuk</a>
        <a href="{{ route('register') }}" class="px-5 py-2 bg-[#1e3a6e] text-white rounded-lg text-sm font-medium hover:bg-[#16305c]">Daftar</a>
    </div>
</nav>

{{-- HERO --}}
<section id="beranda" class="pt-28 pb-20 px-8 md:px-20 flex flex-col md:flex-row items-center justify-between gap-10">
    <div class="max-w-xl">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
            Raih sertifikasi <br> Kompetensi <br> Profesional <br>
            <span class="text-[#1e3a6e]">Anda Sekarang</span>
        </h1>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Tingkatkan kredibilitas dan daya saing Anda di dunia kerja dengan sertifikasi kompetensi yang diakui secara nasional melalui Lembaga Sertifikasi Profesi kami.
        </p>
        <a href="{{ route('register') }}" class="px-8 py-4 bg-[#1e3a6e] text-white font-semibold rounded-lg hover:bg-[#16305c] transition inline-block">
            Daftar Sertifikasi
        </a>
    </div>
    <div class="flex-shrink-0">
        <div class="w-72 h-72 bg-[#e8f0fe] rounded-full flex items-center justify-center">
            <svg width="180" height="180" viewBox="0 0 180 180" fill="none">
                <circle cx="90" cy="70" r="35" fill="#1e3a6e"/>
                <rect x="30" y="110" width="120" height="50" rx="8" fill="#1e3a6e" opacity="0.8"/>
                <circle cx="130" cy="130" r="20" fill="#f59e0b"/>
                <path d="M120 130 L128 138 L142 122" stroke="white" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
</section>

{{-- TENTANG LSP --}}
<section id="tentang" class="py-20 px-8 md:px-20 bg-gray-50">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Tentang LSP</span>
        <h2 class="text-3xl font-bold mt-4">Apa Itu Lembaga Sertifikasi Profesi (LSP)?</h2>
    </div>
    <div class="flex flex-col md:flex-row gap-10 items-center max-w-5xl mx-auto">
        <div class="w-full md:w-1/2 bg-gray-200 rounded-xl h-64 flex items-center justify-center">
            <span class="text-gray-400 text-sm">Foto LSP</span>
        </div>
        <div class="w-full md:w-1/2 space-y-4 text-gray-600 leading-relaxed">
            <p>Lembaga Sertifikasi Profesi (LSP) adalah lembaga independen yang berwenang melaksanakan uji kompetensi kerja dan memberikan sertifikat kompetensi bagi tenaga profesional.</p>
            <p>LSP beroperasi berdasarkan standar nasional (SKKNI) dan berlisensi Badan Nasional Sertifikasi Profesi (BNSP), sehingga hasil sertifikasi resmi, terukur, dan dapat dipertanggungjawabkan.</p>
        </div>
    </div>
</section>

{{-- SKEMA SERTIFIKASI --}}
<section id="skema" class="py-20 px-8 md:px-20">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Skema Sertifikasi</span>
        <h2 class="text-3xl font-bold mt-4">Pilih Skema Sertifikasi Sesuai Kebutuhan</h2>
        <p class="text-gray-500 mt-2">Kami menyediakan berbagai skema sertifikasi yang telah terakreditasi BNSP</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @php
        $skemas = [
            ['kategori' => 'Teknologi Informasi', 'warna' => 'bg-blue-100 text-blue-700', 'nama' => 'Junior Web Developer', 'desc' => 'Kompetensi dalam membangun website dengan HTML, CSS, dan JavaScript.', 'hari' => '2-3', 'peserta' => '134', 'unit' => '8'],
            ['kategori' => 'Pemasaran Digital', 'warna' => 'bg-green-100 text-green-700', 'nama' => 'Digital Marketing Specialist', 'desc' => 'Strategi pemasaran digital, SEO, dan manajemen media sosial.', 'hari' => '2', 'peserta' => '169', 'unit' => '6'],
            ['kategori' => 'Administrasi', 'warna' => 'bg-yellow-100 text-yellow-700', 'nama' => 'Administrasi Perkantoran', 'desc' => 'Kompetensi administrasi perkantoran secara profesional.', 'hari' => '5', 'peserta' => '456', 'unit' => '10'],
            ['kategori' => 'Teknologi Informasi', 'warna' => 'bg-blue-100 text-blue-700', 'nama' => 'Network Administrator', 'desc' => 'Pengelolaan dan pemeliharaan infrastruktur jaringan komputer.', 'hari' => '3', 'peserta' => '161', 'unit' => '12'],
            ['kategori' => 'Desain', 'warna' => 'bg-red-100 text-red-700', 'nama' => 'Graphic Designer', 'desc' => 'Desain grafis, branding, dan pembuatan konten visual.', 'hari' => '2', 'peserta' => '298', 'unit' => '7'],
            ['kategori' => 'Teknologi Informasi', 'warna' => 'bg-blue-100 text-blue-700', 'nama' => 'Data Analyst', 'desc' => 'Analisis data, visualisasi, dan pengambilan keputusan berbasis data.', 'hari' => '3', 'peserta' => '145', 'unit' => '10'],
        ];
        @endphp

        @foreach($skemas as $skema)
        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $skema['warna'] }}">{{ $skema['kategori'] }}</span>
            <h3 class="font-bold text-lg mt-3 mb-2">{{ $skema['nama'] }}</h3>
            <p class="text-gray-500 text-sm mb-4">{{ $skema['desc'] }}</p>
            <div class="flex items-center gap-4 text-xs text-gray-400 mb-4">
                <span>⏱ {{ $skema['hari'] }} Hari</span>
                <span>👥 {{ $skema['peserta'] }} Peserta</span>
                <span>📋 {{ $skema['unit'] }} Unit</span>
            </div>
            <a href="#" class="block text-center border border-[#1e3a6e] text-[#1e3a6e] rounded-lg py-2 text-sm font-medium hover:bg-[#1e3a6e] hover:text-white transition">
                Lihat Detail
            </a>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-10">
        <a href="#" class="px-8 py-3 bg-[#1e3a6e] text-white rounded-lg font-medium hover:bg-[#16305c] transition">Lihat Semua Skema</a>
    </div>
</section>

{{-- ALUR SERTIFIKASI --}}
<section id="alur" class="py-20 px-8 md:px-20 bg-gray-50">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Alur Sertifikasi</span>
        <h2 class="text-3xl font-bold mt-4">Proses Sertifikasi Mudah & Cepat</h2>
        <p class="text-gray-500 mt-2">Ikuti 6 langkah mudah untuk mendapatkan sertifikat kompetensi profesional Anda.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        @php
        $alurs = [
            ['icon' => '📝', 'judul' => 'Registrasi', 'desc' => 'Daftarkan diri Anda melalui sistem online dengan mengisi data lengkap.'],
            ['icon' => '📋', 'judul' => 'Pilih Skema', 'desc' => 'Pilih skema sertifikasi yang sesuai dengan bidang keahlian Anda.'],
            ['icon' => '👤', 'judul' => 'Lengkapi Profil', 'desc' => 'Isi data diri dan unggah dokumen persyaratan yang valid dan benar.'],
            ['icon' => '✅', 'judul' => 'Verifikasi & Jadwal', 'desc' => 'Admin akan memverifikasi dokumen dan menjadwalkan asesmen Anda.'],
            ['icon' => '🎯', 'judul' => 'Uji Kompetensi', 'desc' => 'Ikuti uji kompetensi sesuai jadwal yang telah ditentukan.'],
            ['icon' => '🏆', 'judul' => 'Terima Sertifikat', 'desc' => 'Setelah dinyatakan kompeten, Anda akan menerima sertifikat resmi BNSP.'],
        ];
        @endphp
        @foreach($alurs as $alur)
        <div class="bg-white border border-gray-200 rounded-xl p-6">
            <div class="text-3xl mb-3">{{ $alur['icon'] }}</div>
            <h3 class="font-bold text-base mb-2">{{ $alur['judul'] }}</h3>
            <p class="text-gray-500 text-sm">{{ $alur['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- INFORMASI --}}
<section id="informasi" class="py-20 px-8 md:px-20">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Informasi</span>
        <h2 class="text-3xl font-bold mt-4">Informasi Terbaru</h2>
        <p class="text-gray-500 mt-2">Dapatkan informasi terkini seputar kegiatan dan pengumuman dari LSP kami.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @php
        $infos = [
            ['tanggal' => '5 Desember 2025', 'judul' => 'Pembukaan Pendaftaran Sertifikasi Batch Januari 2026', 'desc' => 'LSP Profesional membuka pendaftaran untuk sertifikasi batch Januari 2026.'],
            ['tanggal' => '28 November 2025', 'judul' => 'Kerjasama dengan Industri untuk Peningkatan Kompetensi', 'desc' => 'LSP menjalin kerjasama strategis dengan berbagai perusahaan teknologi.'],
            ['tanggal' => '10 November 2025', 'judul' => 'Tips Sukses Menghadapi Uji Kompetensi', 'desc' => 'Panduan lengkap persiapan menghadapi uji kompetensi dari para asesor.'],
        ];
        @endphp
        @foreach($infos as $info)
        <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition">
            <div class="bg-gray-200 h-48 flex items-center justify-center">
                <span class="text-gray-400 text-sm">Foto Berita</span>
            </div>
            <div class="p-5">
                <p class="text-xs text-gray-400 mb-2">{{ $info['tanggal'] }}</p>
                <h3 class="font-bold text-base mb-2">{{ $info['judul'] }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $info['desc'] }}</p>
                <a href="#" class="text-[#1e3a6e] text-sm font-medium">Baca Selengkapnya →</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-10">
        <a href="#" class="px-8 py-3 bg-[#1e3a6e] text-white rounded-lg font-medium hover:bg-[#16305c] transition">Lihat Semua Berita</a>
    </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="py-20 px-8 md:px-20 bg-gray-50">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Kontak</span>
        <h2 class="text-3xl font-bold mt-4">Ada Pertanyaan? Hubungi Kami</h2>
        <p class="text-gray-500 mt-2">Tim kami siap membantu menjawab pertanyaan Anda.</p>
    </div>
    <div class="flex flex-col md:flex-row gap-10 max-w-5xl mx-auto">
        <div class="w-full md:w-1/2 bg-[#1e3a6e] text-white rounded-xl p-8 space-y-4">
            <h3 class="font-bold text-lg mb-4">Informasi Kontak</h3>
            <p class="text-sm">📍 Jl. Sertifikasi No. 123, Kuningan 12345</p>
            <p class="text-sm">📞 +62 903 5678 4321</p>
            <p class="text-sm">✉️ lsp.profesional@gmail.com</p>
            <p class="text-sm">🕐 Senin - Jumat: 08.00 - 17.00 WIB</p>
        </div>
        <div class="w-full md:w-1/2 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-1">Nama Lengkap</label>
                    <input type="text" placeholder="Nama Anda" class="w-full px-4 py-3 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-1">No. Telepon</label>
                    <input type="text" placeholder="+62 xxx" class="w-full px-4 py-3 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                </div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Email</label>
                <input type="email" placeholder="email@example.com" class="w-full px-4 py-3 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Subjek</label>
                <input type="text" placeholder="Perihal pesan Anda" class="w-full px-4 py-3 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Pesan</label>
                <textarea rows="4" placeholder="Tulis pesan Anda..." class="w-full px-4 py-3 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"></textarea>
            </div>
            <button class="w-full py-3 bg-[#1e3a6e] text-white font-semibold rounded-lg hover:bg-[#16305c] transition">
                Kirim Pesan
            </button>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-[#1e3a6e] text-white py-12 px-8 md:px-20">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div>
            <h3 class="font-bold text-lg mb-3">LSP <span class="text-orange-400">Profesional</span></h3>
            <p class="text-sm text-blue-200">Lembaga Sertifikasi Profesi terakreditasi BNSP yang berkomitmen membangun tenaga profesional berkualitas standar global.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Layanan</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="#" class="hover:text-white">Jadwal Asesmen</a></li>
                <li><a href="#" class="hover:text-white">Pendaftaran Online</a></li>
                <li><a href="#" class="hover:text-white">Hasil Sertifikasi</a></li>
                <li><a href="#" class="hover:text-white">Skema sertifikasi</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Informasi</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-white">FAQ</a></li>
                <li><a href="#" class="hover:text-white">Karir</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Kebijakan</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                <li><a href="#" class="hover:text-white">Panduan Peserta</a></li>
                <li><a href="#" class="hover:text-white">Pengaduan</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-blue-800 pt-6 text-center text-sm text-blue-300">
        © 2025 LSP Profesional. All rights reserved. Terakreditasi BNSP.
    </div>
</footer>

</body>
</html>