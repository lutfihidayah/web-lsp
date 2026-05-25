<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $info->judul }} | LSP Profesional</title>
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
        <a href="{{ route('guest.informasi.index') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition inline-flex">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Semua Berita
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        
        {{-- NEWS DETAIL --}}
        <article class="w-full lg:w-8/12 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-8 md:p-10">
            <div class="flex items-center gap-3 mb-6">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600 uppercase tracking-wider">
                    {{ $info->kategori }}
                </span>
                <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($info->created_at)->format('d M Y') }}</span>
                <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Dilihat {{ $info->dilihat ?? 0 }} kali
                </span>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $info->judul }}
            </h1>

            <div class="flex items-center gap-3 pb-6 border-b border-gray-100 mb-8">
                <div class="w-9 h-9 rounded-full bg-[#1e3a6e] text-white flex items-center justify-center font-bold text-sm">
                    {{ substr($info->penulis ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $info->penulis ?? 'Admin LSP' }}</p>
                    <p class="text-xs text-gray-400">Penulis Resmi LSP</p>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="prose max-w-none text-gray-600 leading-relaxed text-base space-y-6">
                {!! nl2br(e($info->isi)) !!}
            </div>
        </article>

        {{-- SIDEBAR: LATEST NEWS --}}
        <aside class="w-full lg:w-4/12 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-lg text-gray-900 pb-4 border-b border-gray-100 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                    </svg>
                    Berita Lainnya
                </h3>

                <div class="space-y-6">
                    @if($beritaLainnya->isEmpty())
                        <p class="text-sm text-gray-500">Tidak ada berita terbaru lainnya.</p>
                    @else
                        @foreach($beritaLainnya as $item)
                            <div class="group flex flex-col gap-2">
                                <span class="text-[10px] font-bold text-orange-600 uppercase tracking-widest">{{ $item->kategori }}</span>
                                <h4 class="font-bold text-sm text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <a href="{{ route('guest.informasi.show', $item->id) }}">{{ $item->judul }}</a>
                                </h4>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- BOX HUBUNGI KAMI --}}
            <div class="bg-[#1e3a6e] rounded-3xl p-6 text-white relative overflow-hidden shadow-lg shadow-blue-900/10">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <h4 class="font-bold text-lg mb-2">Butuh Bantuan?</h4>
                    <p class="text-xs text-blue-200 leading-relaxed mb-4">Hubungi tim admin LSP untuk pertanyaan seputar sertifikasi dan pelaksanaan ujian.</p>
                    <a href="/#kontak" class="inline-block w-full py-3 bg-white text-[#1e3a6e] text-center rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                        Hubungi Kontak Kami
                    </a>
                </div>
            </div>
        </aside>

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

</body>
</html>
