<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Skema Sertifikasi | LSP Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

{{-- NAVBAR --}}
<nav class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
    <a href="/" class="text-[#1e3a6e] font-bold text-xl">LSP <span class="text-orange-400">Profesional</span></a>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
        <a href="/#beranda" class="hover:text-[#1e3a6e]">Beranda</a>
        <a href="/#tentang" class="hover:text-[#1e3a6e]">Tentang LSP</a>
        <a href="/#skema" class="hover:text-[#1e3a6e]">Skema</a>
        <a href="/#alur" class="hover:text-[#1e3a6e]">Alur</a>
        <a href="/#informasi" class="hover:text-[#1e3a6e]">Informasi</a>
        <a href="/#kontak" class="hover:text-[#1e3a6e]">Kontak</a>
    </div>
    <div class="flex items-center gap-3">
        @auth
            <span class="text-sm text-gray-600 hidden sm:inline">Halo, <span class="font-bold text-[#1e3a6e]">{{ auth()->user()->name }}</span></span>
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="px-5 py-2 bg-[#1e3a6e] text-white rounded-lg text-sm font-medium hover:bg-[#16305c] transition-all">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="px-5 py-2 border border-[#1e3a6e] text-[#1e3a6e] rounded-lg text-sm font-medium hover:bg-gray-50">Masuk</a>
            <a href="{{ route('register') }}" class="px-5 py-2 bg-[#1e3a6e] text-white rounded-lg text-sm font-medium hover:bg-[#16305c]">Daftar</a>
        @endauth
    </div>
</nav>

{{-- MAIN CONTENT --}}
<main class="flex-1 py-12 px-8 md:px-20 max-w-6xl mx-auto w-full">
    
    <div class="mb-8">
        <a href="/" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition inline-flex">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <div class="text-center mb-12">
        <span class="px-4 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest">Daftar Skema Lengkap</span>
        <h1 class="text-4xl font-extrabold mt-4 mb-3 text-gray-900">Semua Skema Sertifikasi</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Temukan skema sertifikasi resmi terakreditasi BNSP yang sesuai dengan keahlian dan jenjang karir Anda.</p>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-10 flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" id="skema-search" placeholder="Cari skema sertifikasi..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
        </div>

        <!-- Category Filter Buttons -->
        <div class="flex flex-wrap gap-2 w-full md:w-auto" id="filter-container">
            <button onclick="filterCategory('all')" class="category-btn active px-4 py-2 text-xs font-bold rounded-lg bg-[#1e3a6e] text-white transition-all">Semua</button>
            @php
                $categories = $skemas->pluck('kategori')->unique();
            @endphp
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category }}')" class="category-btn px-4 py-2 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">{{ $category }}</button>
            @endforeach
        </div>
    </div>

    {{-- GRID LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="skema-grid">
        @if($skemas->isEmpty())
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100">
                <p class="text-gray-500">Belum ada skema sertifikasi yang tersedia saat ini.</p>
            </div>
        @else
            @foreach($skemas as $skema)
            <div class="skema-card group bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300" data-kategori="{{ $skema->kategori }}" data-nama="{{ strtolower($skema->nama) }}">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-blue-50 text-blue-600">
                    {{ $skema->kategori }}
                </span>
                <h3 class="font-extrabold text-xl mt-4 mb-3 text-gray-900 group-hover:text-[#1e3a6e] transition-colors skema-title">{{ $skema->nama }}</h3>
                <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $skema->deskripsi ?? 'Skema sertifikasi profesional untuk bidang ' . $skema->kategori }}</p>
                
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400 mb-8 pb-6 border-b border-gray-50">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $skema->durasi ?? '1-2 Hari' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        {{ $skema->unit_kompetensi ?? 0 }} Unit
                    </span>
                    <span class="flex items-center gap-1.5 font-bold text-gray-700">
                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Rp {{ number_format($skema->harga ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ url('/sertifikasi/' . $skema->id) }}" class="block text-center bg-gray-50 text-[#1e3a6e] rounded-xl py-3 text-sm font-bold group-hover:bg-[#1e3a6e] group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-900/20 transition-all">
                    Lihat Detail Skema
                </a>
            </div>
            @endforeach
        @endif
    </div>

    <!-- Empty State for Search -->
    <div id="no-results" class="hidden text-center py-16 bg-white rounded-2xl border border-gray-100">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="font-bold text-lg text-gray-900">Skema Tidak Ditemukan</h3>
        <p class="text-gray-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
    </div>

</main>

{{-- FOOTER --}}
<footer class="bg-[#1e3a6e] text-white py-12 px-8 md:px-20 mt-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 max-w-6xl mx-auto w-full">
        <div>
            <h3 class="font-bold text-lg mb-3">LSP <span class="text-orange-400">Profesional</span></h3>
            <p class="text-sm text-blue-200">Lembaga Sertifikasi Profesi terakreditasi BNSP yang berkomitmen membangun tenaga profesional berkualitas standar global.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Layanan</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="/#alur" class="hover:text-white">Jadwal Asesmen</a></li>
                <li><a href="/#skema" class="hover:text-white">Pendaftaran Online</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Informasi</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="/#tentang" class="hover:text-white">Tentang Kami</a></li>
                <li><a href="/#informasi" class="hover:text-white">Berita Terbaru</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Kontak</h4>
            <ul class="space-y-2 text-sm text-blue-200">
                <li><a href="/#kontak" class="hover:text-white">Hubungi Kami</a></li>
                <li><a href="#" class="hover:text-white">FAQ</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-blue-800 pt-6 text-center text-sm text-blue-300 max-w-6xl mx-auto w-full">
        © {{ date('Y') }} LSP Profesional. All rights reserved. Terakreditasi BNSP.
    </div>
</footer>

<script>
    let activeCategory = 'all';

    function filterCategory(category) {
        activeCategory = category;
        
        // Update button states
        const buttons = document.querySelectorAll('#filter-container button');
        buttons.forEach(btn => {
            btn.classList.remove('bg-[#1e3a6e]', 'text-white', 'category-btn', 'active');
            btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
        });

        const clickedBtn = event.currentTarget;
        clickedBtn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
        clickedBtn.classList.add('bg-[#1e3a6e]', 'text-white', 'category-btn', 'active');

        applyFilters();
    }

    document.getElementById('skema-search').addEventListener('input', function() {
        applyFilters();
    });

    function applyFilters() {
        const searchQuery = document.getElementById('skema-search').value.toLowerCase();
        const cards = document.querySelectorAll('.skema-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-kategori');
            const cardNama = card.getAttribute('data-nama');

            const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
            const matchesSearch = cardNama.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('no-results');
        const grid = document.getElementById('skema-grid');

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }
</script>

</body>
</html>
