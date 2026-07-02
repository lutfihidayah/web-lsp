<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP Profesional - Sertifikasi Kompetensi Terpercaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(30, 58, 110, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(245, 158, 11, 0.05), transparent);
        }
        .step-card:hover .icon-container {
            transform: scale(1.1) rotate(5deg);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

{{-- NAVBAR --}}
<nav x-data="{ mobileMenuOpen: false }" class="fixed top-0 left-0 right-0 z-50 glass px-5 md:px-8 py-4 flex items-center justify-between">
    <a href="/" class="text-[#1e3a6e] font-extrabold text-2xl tracking-tight">LSP<span class="text-orange-500">PRO</span></a>
    
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
        <a href="#beranda" class="hover:text-[#1e3a6e] transition-colors">Beranda</a>
        <a href="#tentang" class="hover:text-[#1e3a6e] transition-colors">Tentang LSP</a>
        <a href="#skema" class="hover:text-[#1e3a6e] transition-colors">Skema</a>
        <a href="#alur" class="hover:text-[#1e3a6e] transition-colors">Alur</a>
        <a href="#informasi" class="hover:text-[#1e3a6e] transition-colors">Informasi</a>
        <a href="#kontak" class="hover:text-[#1e3a6e] transition-colors">Kontak</a>
    </div>

    <div class="flex items-center gap-3">
        @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none rounded-full p-0.5 transition-all">
                    <span class="text-sm text-gray-600 hidden sm:inline">Halo, <span class="font-bold text-[#1e3a6e]">{{ auth()->user()->name }}</span></span>
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gradient-to-tr from-[#1e3a6e] to-blue-500 text-white flex items-center justify-center font-bold text-base shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <svg class="w-4 h-4 text-gray-600 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

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
                    
                    <div class="px-4 py-3 border-b border-gray-50 text-left">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Masuk Sebagai</p>
                        <p class="text-sm font-bold text-gray-900 truncate mt-0.5">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                    </div>

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
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('login') }}" class="px-5 py-2.5 border border-[#1e3a6e] text-[#1e3a6e] rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#1e3a6e] text-white rounded-xl text-sm font-bold hover:bg-[#16305c] transition-all">Daftar</a>
            </div>
        @endguest

        <!-- Mobile Menu Toggle Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-gray-600 focus:outline-none hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
         @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 -translate-y-4"
         x-transition:enter-end="transform opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 translate-y-0"
         x-transition:leave-end="transform opacity-0 -translate-y-4"
         class="absolute top-[100%] left-0 right-0 bg-white border-t border-gray-100 shadow-xl p-5 flex flex-col gap-4 md:hidden z-40"
         style="display: none;">
        
        <a href="#beranda" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Beranda</a>
        <a href="#tentang" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Tentang LSP</a>
        <a href="#skema" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Skema</a>
        <a href="#alur" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Alur</a>
        <a href="#informasi" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Informasi</a>
        <a href="#kontak" @click="mobileMenuOpen = false" class="text-gray-700 hover:text-[#1e3a6e] font-semibold text-base py-2">Kontak</a>
        
        @guest
            <hr class="border-gray-100 my-2">
            <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 border-2 border-[#1e3a6e] text-[#1e3a6e] rounded-xl text-base font-bold transition-all">Masuk</a>
            <a href="{{ route('register') }}" class="w-full text-center px-5 py-3 bg-[#1e3a6e] text-white rounded-xl text-base font-bold transition-all mt-2">Daftar</a>
        @endguest
    </div>
</nav>

{{-- HERO --}}
<section id="beranda" class="pt-28 md:pt-32 pb-16 md:pb-24 px-5 md:px-20 flex flex-col md:flex-row items-center justify-between gap-12 hero-gradient">
    <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            Terakreditasi BNSP Resmi
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.1] md:leading-[1.1] mb-6">
            Raih Sertifikasi <br> 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1e3a6e] to-blue-600">Kompetensi Profesional</span> <br>
            Sekarang Juga
        </h1>
        <p class="text-lg text-gray-600 mb-10 leading-relaxed max-w-lg">
            Tingkatkan nilai tawar dan kredibilitas profesional Anda dengan sertifikasi yang diakui secara nasional. Proses mudah, transparan, dan terpercaya.
        </p>
        <div class="flex flex-col sm:flex-row items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-4 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1 text-center">
                    Buka Dashboard
                </a>
            @endauth
            @guest
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1 text-center">
                    Daftar Sertifikasi
                </a>
            @endguest
            <a href="#skema" class="w-full sm:w-auto px-10 py-4 bg-white text-[#1e3a6e] font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all text-center">
                Lihat Skema
            </a>
        </div>
    </div>
    <div class="relative">
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-orange-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="relative w-64 h-64 sm:w-72 sm:h-72 md:w-[450px] md:h-[450px] rounded-3xl overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500 mx-auto">
            <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?q=80&w=1974&auto=format&fit=crop" alt="Professional Certification" class="w-full h-full object-cover">
        </div>
    </div>
</section>

{{-- TENTANG LSP --}}
<section id="tentang" class="py-16 md:py-24 px-5 md:px-20 bg-gray-50">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-16 items-center">
        <div class="w-full md:w-1/2 relative">
            <div class="absolute -z-10 top-4 -left-4 w-full h-full border-2 border-orange-200 rounded-2xl"></div>
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop" alt="LSP Office" class="rounded-2xl shadow-xl w-full h-[250px] md:h-[400px] object-cover">
            <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-xl shadow-lg hidden md:block">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 text-xl">🏆</div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">10k+</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Peserta Tersertifikasi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest mb-6">Tentang Kami</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Membangun Standardisasi Kompetensi Nasional</h2>
            <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                <p>Lembaga Sertifikasi Profesi (LSP) adalah lembaga independen yang berwenang melaksanakan uji kompetensi kerja dan memberikan sertifikat kompetensi bagi tenaga profesional.</p>
                <p>LSP beroperasi berdasarkan standar nasional (SKKNI) dan berlisensi Badan Nasional Sertifikasi Profesi (BNSP), sehingga hasil sertifikasi resmi, terukur, dan dapat dipertanggungjawabkan di tingkat nasional maupun internasional.</p>
            </div>
            <div class="mt-10 grid grid-cols-2 gap-6">
                <div class="flex items-start gap-3">
                    <div class="mt-1 flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Lisensi Resmi BNSP</span>
                </div>
                <div class="flex items-start gap-3">
                    <div class="mt-1 flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Asesor Berpengalaman</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SKEMA SERTIFIKASI --}}
<section id="skema" class="py-16 md:py-20 px-5 md:px-20">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Skema Sertifikasi</span>
        <h2 class="text-3xl font-bold mt-4">Pilih Skema Sertifikasi Sesuai Kebutuhan</h2>
        <p class="text-gray-500 mt-2">Kami menyediakan berbagai skema sertifikasi yang telah terakreditasi BNSP</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @if($skemas->isEmpty())
            <div class="col-span-3 text-center py-10">
                <p class="text-gray-500">Belum ada skema sertifikasi yang tersedia saat ini.</p>
            </div>
        @else
            @foreach($skemas as $skema)
            <div class="group bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-blue-50 text-blue-600">
                    {{ $skema->kategori }}
                </span>
                <h3 class="font-extrabold text-xl mt-4 mb-3 text-gray-900 group-hover:text-[#1e3a6e] transition-colors">{{ $skema->nama }}</h3>
                <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $skema->deskripsi ?? 'Skema sertifikasi profesional untuk bidang ' . $skema->kategori }}</p>
                
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400 mb-8 pb-6 border-b border-gray-50">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $skema->durasi ?? '1-2 Hari' }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        {{ $skema->unit_kompetensi ?? 0 }} Unit
                    </span>
                    <span class="flex items-center gap-1.5 font-bold text-gray-700">
                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
    <div class="text-center mt-10">
        <a href="{{ route('guest.skema.index') }}" class="px-8 py-3 bg-[#1e3a6e] text-white rounded-lg font-medium hover:bg-[#16305c] transition">Lihat Semua Skema</a>
    </div>
</section>

{{-- ALUR SERTIFIKASI --}}
<section id="alur" class="py-16 md:py-24 px-5 md:px-20 bg-white">
    <div class="text-center mb-16">
        <span class="inline-block px-4 py-1.5 bg-orange-100 text-orange-700 rounded-full text-xs font-bold uppercase tracking-widest mb-4">Proses Kerja</span>
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Alur Sertifikasi Profesional</h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">Ikuti langkah-langkah sistematis berikut untuk mendapatkan pengakuan kompetensi resmi.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        @php
        $alurs = [
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>', 
                'judul' => 'Registrasi Akun', 
                'desc' => 'Daftarkan diri Anda melalui portal pendaftaran online dengan data yang valid.'
            ],
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>', 
                'judul' => 'Pilih Skema', 
                'desc' => 'Tentukan skema sertifikasi yang sesuai dengan bidang keahlian dan karir Anda.'
            ],
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>', 
                'judul' => 'Lakukan Pembayaran', 
                'desc' => 'Lakukan Pembayran untuk medapatkan askses sertifikasi'
            ],
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16l2 2 4-4" /></svg>', 
                'judul' => 'Verifikasi & Jadwal', 
                'desc' => 'Admin akan melakukan verifikasi dan menjadwalkan waktu asesmen Anda.'
            ],
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>', 
                'judul' => 'Uji Kompetensi', 
                'desc' => 'Pelaksanaan asesmen oleh asesor profesional secara objektif dan transparan.'
            ],
            [
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>', 
                'judul' => 'Sertifikat Terbit', 
                'desc' => 'Dapatkan sertifikat kompetensi BNSP yang diakui secara nasional setelah lulus.'
            ],
        ];
        @endphp
        @foreach($alurs as $index => $alur)
        <div class="step-card group bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-xl hover:border-blue-100 transition-all duration-300 relative">
            <div class="absolute -top-4 -right-4 w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                {{ $index + 1 }}
            </div>
            <div class="icon-container w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center mb-6 transition-transform duration-300">
                {!! $alur['icon'] !!}
            </div>
            <h3 class="font-bold text-xl mb-3 text-gray-900">{{ $alur['judul'] }}</h3>
            <p class="text-gray-500 leading-relaxed">{{ $alur['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- INFORMASI --}}
<section id="informasi" class="py-16 md:py-20 px-5 md:px-20">
    <div class="text-center mb-12">
        <span class="px-4 py-1 border border-gray-300 rounded-full text-sm text-gray-500">Informasi</span>
        <h2 class="text-3xl font-bold mt-4">Informasi Terbaru</h2>
        <p class="text-gray-500 mt-2">Dapatkan informasi terkini seputar kegiatan dan pengumuman dari LSP kami.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @if($informasi->isEmpty())
            <div class="col-span-3 text-center py-10">
                <p class="text-gray-500">Belum ada informasi terbaru saat ini.</p>
            </div>
        @else
            @foreach($informasi as $info)
            <div class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="relative h-52 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a6e] to-blue-500 opacity-90 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-orange-50 text-orange-600 uppercase tracking-widest">
                            {{ $info->kategori }}
                        </span>
                        <p class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($info->created_at)->format('d M Y') }}</p>
                    </div>
                    <h3 class="font-bold text-lg mb-3 line-clamp-2 text-gray-900 group-hover:text-blue-600 transition-colors">{{ $info->judul }}</h3>
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
    <div class="text-center mt-10">
        <a href="{{ route('guest.informasi.index') }}" class="px-8 py-3 bg-[#1e3a6e] text-white rounded-lg font-medium hover:bg-[#16305c] transition">Lihat Semua Berita</a>
    </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="py-16 md:py-24 px-5 md:px-20 bg-gray-50/50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest mb-4">Hubungi Kami</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Ada Pertanyaan? Kami Siap Membantu</h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">Tim kami akan merespons pesan Anda sesegera mungkin untuk memberikan solusi terbaik.</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12">
            {{-- Contact Info Card --}}
            <div class="w-full lg:w-5/12 bg-[#1e3a6e] rounded-3xl p-10 text-white relative overflow-hidden shadow-2xl shadow-blue-900/20">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-8">Informasi Kontak</h3>
                    <div class="space-y-8">
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-blue-200 text-xs font-bold uppercase tracking-wider mb-1">Kantor Pusat</p>
                                <p class="text-lg">Jl. Raya Cigugur, Kuningan, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45511</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </div>
                            <div>
                                <p class="text-blue-200 text-xs font-bold uppercase tracking-wider mb-1">Telepon</p>
                                <p class="text-lg">+62 895 6024 885588</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-blue-200 text-xs font-bold uppercase tracking-wider mb-1">Email Resmi</p>
                                <p class="text-lg">info@lspprofesional.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-5">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-blue-200 text-xs font-bold uppercase tracking-wider mb-1">Jam Operasional</p>
                                <p class="text-lg">Senin - Jumat: 08.00 - 17.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="w-full lg:w-7/12 bg-white rounded-3xl p-10 shadow-xl shadow-gray-200/50">
                <form action="#" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama" class="w-full px-5 py-4 bg-gray-50 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">No. WhatsApp</label>
                            <input type="text" placeholder="08xxxx" class="w-full px-5 py-4 bg-gray-50 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                        <input type="email" placeholder="email@contoh.com" class="w-full px-5 py-4 bg-gray-50 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Subjek</label>
                        <input type="text" placeholder="Apa yang ingin Anda tanyakan?" class="w-full px-5 py-4 bg-gray-50 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Pesan Anda</label>
                        <textarea rows="4" placeholder="Tuliskan pesan lengkap di sini..." class="w-full px-5 py-4 bg-gray-50 border-transparent rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all outline-none resize-none"></textarea>
                    </div>
                    <button class="w-full py-5 bg-[#1e3a6e] text-white font-bold rounded-2xl hover:bg-[#16305c] shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-[#1e3a6e] text-white py-12 px-5 md:px-20">
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