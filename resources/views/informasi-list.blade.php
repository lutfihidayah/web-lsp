<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi & Berita Terbaru | Sertify</title>
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
    <a href="/" class="text-[#1e3a6e] font-bold text-xl">Sertify</a>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
        <a href="/#beranda" class="hover:text-[#1e3a6e]">Beranda</a>
        <a href="/#tentang" class="hover:text-[#1e3a6e]">Tentang Sertify</a>
        <a href="/#skema" class="hover:text-[#1e3a6e]">Skema</a>
        <a href="/#alur" class="hover:text-[#1e3a6e]">Alur</a>
        <a href="/#informasi" class="hover:text-[#1e3a6e]">Informasi</a>
        <a href="/#kontak" class="hover:text-[#1e3a6e]">Kontak</a>
    </div>
    <div class="flex items-center gap-3">
        @auth
            <div x-data="{ open: false }" class="relative">
                <!-- Trigger Button -->
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none rounded-full p-0.5 transition-all">
                    <span class="text-sm text-gray-600 hidden sm:inline">Halo, <span class="font-bold text-[#1e3a6e]">{{ auth()->user()->name }}</span></span>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#1e3a6e] to-blue-500 text-white flex items-center justify-center font-bold text-base shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <svg class="w-4 h-4 text-gray-600 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 origin-top-right"
                     style="display: none;">
                    
                    <!-- User Info Header -->
                    <div class="px-4 py-3 border-b border-gray-50 text-left">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Sudah Masuk Sebagai</p>
                        <p class="text-sm font-bold text-gray-900 truncate mt-0.5">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                    </div>

                    <!-- Links -->
                    <div class="p-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-xl transition-all text-left">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all text-left">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="px-5 py-2 border border-[#1e3a6e] text-[#1e3a6e] rounded-lg text-sm font-medium hover:bg-gray-50">Masuk</a>
            <a href="{{ route('register') }}" class="px-5 py-2 bg-[#1e3a6e] text-white rounded-lg text-sm font-medium hover:bg-[#16305c]">Daftar</a>
        @endguest
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
        <span class="px-4 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-bold uppercase tracking-widest">Pusat Informasi</span>
        <h1 class="text-4xl font-extrabold mt-4 mb-3 text-gray-900">Kumpulan Informasi & Berita</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Dapatkan pengumuman terbaru, tips asesmen, dan berita menarik seputar kegiatan sertifikasi kami.</p>
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
            <input type="text" id="info-search" placeholder="Cari informasi atau berita..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
        </div>

        <!-- Category Filter Buttons -->
        <div class="flex flex-wrap gap-2 w-full md:w-auto" id="filter-container">
            <button onclick="filterCategory('all')" class="category-btn active px-4 py-2 text-xs font-bold rounded-lg bg-[#1e3a6e] text-white transition-all">Semua</button>
            @php
                $categories = $informasi->pluck('kategori')->unique();
            @endphp
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category }}')" class="category-btn px-4 py-2 text-xs font-bold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">{{ $category }}</button>
            @endforeach
        </div>
    </div>

    {{-- GRID LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="info-grid">
        @if($informasi->isEmpty())
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100">
                <p class="text-gray-500">Belum ada informasi terbaru saat ini.</p>
            </div>
        @else
            @foreach($informasi as $info)
            <div class="info-card group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300" data-kategori="{{ $info->kategori }}" data-judul="{{ strtolower($info->judul) }}" data-isi="{{ strtolower($info->isi) }}">
                <div class="relative h-52 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a6e] to-blue-500 opacity-90 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-orange-50 text-orange-600 uppercase tracking-widest">
                            {{ $info->kategori }}
                        </span>
                        <p class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($info->created_at)->format('d M Y') }}</p>
                    </div>
                    <h3 class="font-bold text-lg mb-3 line-clamp-2 text-gray-900 group-hover:text-blue-600 transition-colors info-title">{{ $info->judul }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">{{ $info->isi }}</p>
                    <a href="{{ route('guest.informasi.show', $info->id) }}" class="inline-flex items-center gap-2 text-[#1e3a6e] text-sm font-bold group-hover:gap-3 transition-all">
                        Baca Selengkapnya 
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
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
        <h3 class="font-bold text-lg text-gray-900">Informasi Tidak Ditemukan</h3>
        <p class="text-gray-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
    </div>

</main>

{{-- FOOTER --}}
<footer class="bg-[#1e3a6e] text-white py-12 px-8 md:px-20 mt-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 max-w-6xl mx-auto w-full">
        <div>
            <h3 class="font-bold text-lg mb-3">Sertify</h3>
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
        © {{ date('Y') }} Sertify. All rights reserved. Terakreditasi BNSP.
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

    document.getElementById('info-search').addEventListener('input', function() {
        applyFilters();
    });

    function applyFilters() {
        const searchQuery = document.getElementById('info-search').value.toLowerCase();
        const cards = document.querySelectorAll('.info-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-kategori');
            const cardJudul = card.getAttribute('data-judul');
            const cardIsi = card.getAttribute('data-isi');

            const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
            const matchesSearch = cardJudul.includes(searchQuery) || cardIsi.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('no-results');

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }
</script>

</body>
</html>
