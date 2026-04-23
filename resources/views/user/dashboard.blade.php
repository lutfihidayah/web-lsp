@extends('user.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- WELCOME BANNER --}}
<div class="bg-white rounded-2xl p-6 mb-6 flex items-center justify-between shadow-sm border border-gray-100">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Hallo, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-500 text-sm mt-1">Selamat datang kembali di Dashboard Sertifikasi. Pantau progress sertifikasimu dan persiapkan diri untuk asesmen.</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="bg-[#1e3a6e] text-white rounded-xl px-5 py-4 text-center min-w-[140px]">
            <p class="text-xs font-semibold text-blue-200 leading-tight">Skema Sedang<br>di Ikuti</p>
            <div class="flex items-center justify-between mt-2">
                <p class="text-2xl font-bold">3</p>
            </div>
        </div>
        <div class="bg-[#1e3a6e] text-white rounded-xl px-5 py-4 text-center min-w-[140px]">
            <p class="text-xs font-semibold text-blue-200 leading-tight">Riwayat Acara<br>Sertifikasi</p>
            <div class="flex items-center justify-between mt-2">
                <p class="text-2xl font-bold">5</p>
            </div>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    {{-- Card 1 --}}
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">3</p>
        <p class="text-sm text-gray-500 mt-0.5">Skema Diikuti</p>
    </div>

    {{-- Card 2 --}}
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-green-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#16A34A" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">2</p>
        <p class="text-sm text-gray-500 mt-0.5">Kompeten</p>
    </div>

    {{-- Card 3 --}}
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#EA580C" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">1</p>
        <p class="text-sm text-gray-500 mt-0.5">Jadwal Mendatang</p>
    </div>

    {{-- Card 4 --}}
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#9333EA" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">5</p>
        <p class="text-sm text-gray-500 mt-0.5">Total Sertifikasi</p>
    </div>
</div>

{{-- BERITA HARI INI --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-5">Berita Hari Ini</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Berita 1 --}}
        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer">
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 h-36 flex items-center justify-center">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div class="p-4">
                <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">Pengumuman</span>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Pembukaan Pendaftaran Sertifikasi Batch Januari 2026</h4>
                <p class="text-xs text-gray-500">LSP Profesional membuka pendaftaran untuk batch Januari 2026</p>
            </div>
        </div>

        {{-- Berita 2 --}}
        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 h-36 flex items-center justify-center">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="p-4">
                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">Info</span>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Kerjasama Dengan Industri Untuk Meningkatkan Kompetensi</h4>
                <p class="text-xs text-gray-500">LSP Profesional membuka pendaftaran untuk batch Januari 2026</p>
            </div>
        </div>

        {{-- Berita 3 --}}
        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer">
            <div class="bg-gradient-to-br from-purple-500 to-pink-500 h-36 flex items-center justify-center">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                </svg>
            </div>
            <div class="p-4">
                <span class="inline-block bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">Tips</span>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Tips Sukses Sertifikasi</h4>
                <p class="text-xs text-gray-500">LSP Profesional membuka pendaftaran untuk batch Januari 2026</p>
            </div>
        </div>

    </div>
</div>

@endsection