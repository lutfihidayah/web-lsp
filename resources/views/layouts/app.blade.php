<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LSP Profesional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            aside, header { display: none !important; }
            .ml-64 { margin-left: 0 !important; }
            main { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
            .no-print { display: none !important; }
            body, .bg-gray-100 { background-color: white !important; }
            .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex">

@php $role = auth()->user()->role; @endphp

{{-- SIDEBAR --}}
<aside class="w-64 h-screen bg-[#1e3a6e] text-white flex flex-col fixed left-0 top-0 overflow-y-auto" style="background: linear-gradient(180deg, #1a3366 0%, #1e3a6e 100%);">
    <div class="p-6 border-b border-blue-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="#1e3a6e">
                    <rect x="1" y="1" width="6" height="6" rx="1"/>
                    <rect x="9" y="1" width="6" height="6" rx="1"/>
                    <rect x="1" y="9" width="6" height="6" rx="1"/>
                    <rect x="9" y="9" width="6" height="6" rx="1"/>
                </svg>
            </div>
            <span class="font-bold text-lg">LSP Profesional</span>
        </div>
        <div class="mt-2">
            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ in_array($role, ['admin', 'superadmin', 'asesor']) ? 'bg-yellow-400 text-yellow-900' : 'bg-blue-300 text-blue-900' }}">
                {{ strtoupper($role) }}
            </span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <p class="text-xs text-blue-300 font-medium px-3 py-2 uppercase tracking-wider">Main Menu</p>

        {{-- Dashboard (semua role) --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('dashboard') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        @if(in_array($role, ['admin', 'superadmin', 'asesor']))
        {{-- ========== MENU ADMIN / STAFF ========== --}}

        @if(in_array($role, ['admin', 'superadmin']))
        <a href="{{ route('peserta.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('peserta.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Daftar Peserta
        </a>
        @endif

        <a href="{{ route('skema.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('skema.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
            </svg>
            Skema Sertifikasi
        </a>

        <a href="{{ route('jadwal.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('jadwal.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Asesmen
        </a>

        <a href="{{ route('hasil.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('hasil.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Hasil Sertifikasi
        </a>

        @if(in_array($role, ['admin', 'superadmin']))
        <a href="{{ route('soal.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('soal.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            Bank Soal
        </a>

        <a href="{{ route('informasi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('informasi.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Informasi
        </a>

        <a href="{{ route('laporan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('laporan.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Laporan
        </a>
        @endif

        <a href="{{ route('asesmen.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('asesmen.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Monitoring Asesmen
        </a>

        @if($role === 'superadmin')
        <p class="text-xs text-blue-300 font-medium px-3 py-2 mt-3 uppercase tracking-wider">Sistem</p>

        <a href="{{ route('users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('users.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
            </svg>
            User Management
        </a>
        @endif

        @else
        {{-- ========== MENU USER ========== --}}

        <a href="{{ route('skema.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('skema.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
            </svg>
            Daftar Skema
        </a>

        <a href="{{ route('jadwal.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('jadwal.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Asesmen
        </a>

        <a href="{{ route('pembayaran.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('pembayaran.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Pembayaran
        </a>

        <a href="{{ route('asesmen.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('asesmen.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Asesmen
        </a>

        <a href="{{ route('hasil.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('hasil.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Hasil Sertifikasi
        </a>

        <a href="{{ route('setting.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('setting.*') ? 'bg-white text-[#1e3a6e]' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Setting
        </a>

        @endif
    </nav>

    <div class="p-4 border-t border-blue-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-blue-100 hover:bg-blue-800 transition w-full">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<div class="ml-64 flex-1 min-h-screen flex flex-col">

    {{-- TOPBAR --}}
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
        <div>
            <p class="text-xs text-gray-400">Pages / <span class="text-gray-600">@yield('page-title', 'Dashboard')</span></p>
            <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" placeholder="Search..."
                    class="pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] w-64">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[#1e3a6e] rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </header>

    {{-- FLASH MESSAGES --}}
    <div class="px-8 pt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm mb-4 flex items-center gap-2">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm mb-4 flex items-center gap-2">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-lg px-4 py-3 text-sm mb-4">
                {{ session('info') }}
            </div>
        @endif
    </div>

    {{-- PAGE CONTENT --}}
    <main class="px-8 pb-8 pt-4 flex-1">
        @yield('content')
    </main>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportExcel(filename) {
        let table = document.querySelector('table');
        if (!table) { alert("Tidak ada tabel untuk diexport"); return; }
        let clone = table.cloneNode(true);
        clone.querySelectorAll('.no-print').forEach(el => el.remove());
        let wb = XLSX.utils.table_to_book(clone, {sheet:"Data"});
        XLSX.writeFile(wb, filename + ".xlsx");
    }

    function exportPDF() { window.print(); }

    function openModal(id) {
        let modal = document.getElementById(id);
        if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
    }

    function closeModal(id) {
        let modal = document.getElementById(id);
        if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
    }
</script>
</body>
</html>
