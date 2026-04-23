<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LSP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex">

{{-- SIDEBAR --}}
<aside class="w-60 min-h-screen bg-[#1e3a6e] text-white flex flex-col fixed left-0 top-0" style="background: linear-gradient(180deg, #1a3366 0%, #1e3a6e 100%);">
    {{-- LOGO --}}
    <div class="px-5 py-6 border-b border-blue-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="#1e3a6e">
                    <rect x="1" y="1" width="6" height="6" rx="1"/>
                    <rect x="9" y="1" width="6" height="6" rx="1"/>
                    <rect x="1" y="9" width="6" height="6" rx="1"/>
                    <rect x="9" y="9" width="6" height="6" rx="1"/>
                </svg>
            </div>
            <span class="font-semibold text-base text-white">LSP Profesional</span>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 px-4 py-4 space-y-1">
        <p class="text-xs text-blue-300 font-medium px-3 py-2 uppercase tracking-wider">Main Menu</p>

        <a href="{{ route('user.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('user.dashboard') ? 'bg-[#1e3972] text-white' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Overview
        </a>

        <a href="{{ route('user.skema') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('user.skema*') ? 'bg-[#1e3972] text-white' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
            </svg>
            Daftar Skema
        </a>

        <a href="{{ route('user.jadwal') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('user.jadwal') ? 'bg-[#1e3972] text-white' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Asesmen
        </a>

        <a href="{{ route('user.hasil') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('user.hasil') ? 'bg-[#1e3972] text-white' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Hasil Sertifikasi
        </a>

        <a href="{{ route('user.setting') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('user.setting') ? 'bg-[#1e3972] text-white' : 'text-blue-100 hover:bg-blue-800' }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Setting
        </a>
    </nav>

    {{-- LOGOUT --}}
    <div class="px-4 py-4 border-t border-blue-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-blue-100 hover:bg-blue-800 transition w-full">
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
<div class="ml-60 flex-1 min-h-screen flex flex-col">

    {{-- TOPBAR --}}
    <header class="bg-gray-50 border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
        <div>
            <p class="text-xs text-gray-400">Pages / <span class="text-gray-600 font-medium">@yield('page-title', 'Dashboard')</span></p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Search --}}
            <div class="relative">
                <input type="text" placeholder="Search..."
                    class="pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] w-56">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </div>

            {{-- Notifikasi --}}
            <button class="w-9 h-9 bg-white border border-gray-200 rounded-full flex items-center justify-center relative hover:bg-gray-50 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-400 rounded-full"></span>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-full px-3 py-1.5">
                <div class="w-6 h-6 bg-[#1e3a6e] rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </div>
        </div>
    </header>

    {{-- PAGE CONTENT --}}
    <main class="p-8 flex-1">
        @yield('content')
    </main>
</div>

</body>
</html>