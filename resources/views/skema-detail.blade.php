<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Skema - {{ $skema->nama }} | Sertify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <div class="mb-6">
        <a href="/#skema" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition inline-flex">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Daftar Skema
        </a>
    </div>

    @php
        $kategoriColor = match($skema->kategori) {
            'Teknologi Informasi' => 'from-blue-500 to-blue-700',
            'Pemasaran Digital'   => 'from-purple-500 to-pink-500',
            'Administrasi'        => 'from-yellow-400 to-orange-400',
            'Desain'              => 'from-red-400 to-pink-500',
            default               => 'from-gray-400 to-gray-600',
        };
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- BANNER --}}
        <div class="h-56 bg-gradient-to-br {{ $kategoriColor }} flex items-center justify-center relative">
            <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1" class="opacity-80">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
            </svg>
            <span class="absolute top-5 right-5 bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                {{ $skema->status }}
            </span>
        </div>

        <div class="p-8 md:p-10">
            {{-- JUDUL --}}
            <div class="mb-8">
                <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full uppercase tracking-wide">
                    {{ $skema->kategori }}
                </span>
                <h1 class="text-3xl font-bold text-gray-900 mt-4 mb-3">{{ $skema->nama }}</h1>
                <p class="text-gray-600 leading-relaxed text-lg">
                    {{ $skema->deskripsi ?? 'Skema sertifikasi ini dirancang untuk memastikan kompetensi profesional Anda di bidang ' . $skema->kategori . '. Dapatkan pengakuan resmi dari BNSP untuk meningkatkan nilai jual dan peluang karir Anda.' }}
                </p>
            </div>

            {{-- INFO CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <p class="text-xs text-blue-600 font-medium mb-1">Lokasi Asesmen</p>
                    <p class="text-base font-bold text-gray-900">Gedung Sertify Pusat</p>
                </div>
                <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                    <p class="text-xs text-green-600 font-medium mb-1">Status Skema</p>
                    <p class="text-base font-bold text-gray-900">Terakreditasi BNSP</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                    <p class="text-xs text-orange-600 font-medium mb-1">Durasi Ujian</p>
                    <p class="text-base font-bold text-gray-900">{{ $skema->durasi ?? '1-2 Hari' }}</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                    <p class="text-xs text-purple-600 font-medium mb-1">Biaya Sertifikasi</p>
                    <p class="text-base font-bold text-purple-700">Rp {{ number_format($skema->harga ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- UNIT KOMPETENSI --}}
            <div class="mb-10">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Persyaratan & Unit Kompetensi
                </h3>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                    <p class="text-gray-700 mb-4">Untuk mengikuti sertifikasi ini, peserta akan diuji dalam <strong>{{ $skema->unit_kompetensi ?? 0 }} unit kompetensi</strong> yang mencakup berbagai aspek keterampilan, pengetahuan, dan sikap kerja yang relevan.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-white p-3 border border-gray-200 rounded-lg inline-block">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="green" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sertifikat berlaku selama 3 tahun
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="border-t border-gray-100 pt-8 flex flex-col sm:flex-row items-center gap-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('skema.index') }}" class="w-full sm:w-auto text-center px-8 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                            Kelola Skema di Admin
                        </a>
                    @else
                        <a href="{{ route('skema.show', $skema->id) }}" class="w-full sm:w-auto text-center px-8 py-3.5 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] transition flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Daftar Sertifikasi Sekarang
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto text-center px-8 py-3.5 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] transition flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login untuk Mendaftar
                    </a>
                    <p class="text-sm text-gray-500 text-center sm:text-left mt-2 sm:mt-0">Belum punya akun? <a href="{{ route('register') }}" class="text-[#1e3a6e] font-semibold hover:underline">Daftar disini</a></p>
                @endauth
            </div>

        </div>
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

</body>
</html>
