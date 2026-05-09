@extends('user.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- WELCOME BANNER --}}
@if($informasi->isNotEmpty())
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3 shadow-sm">
    <div class="bg-blue-100 p-2 rounded-lg mt-0.5">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
    </div>
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="text-xs font-bold bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Pengumuman Terbaru</span>
            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($informasi->first()->created_at)->diffForHumans() }}</span>
        </div>
        <h4 class="font-bold text-gray-900 text-sm">{{ $informasi->first()->judul }}</h4>
        <p class="text-xs text-gray-600 mt-1 line-clamp-1">{{ $informasi->first()->isi }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl p-6 mb-6 flex items-center justify-between shadow-sm border border-gray-100">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Hallo, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-500 text-sm mt-1">Selamat datang kembali di Dashboard Sertifikasi. Pantau progress sertifikasimu dan persiapkan diri untuk asesmen.</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="bg-[#1e3a6e] text-white rounded-xl px-5 py-4 text-center min-w-[140px]">
            <p class="text-xs font-semibold text-blue-200 leading-tight">Skema Sedang<br>di Ikuti</p>
            <p class="text-2xl font-bold mt-2">{{ $skemaCount }}</p>
        </div>
        <div class="bg-[#1e3a6e] text-white rounded-xl px-5 py-4 text-center min-w-[140px]">
            <p class="text-xs font-semibold text-blue-200 leading-tight">Sertifikat<br>Kompeten</p>
            <p class="text-2xl font-bold mt-2">{{ $kompeten }}</p>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $skemaCount }}</p>
        <p class="text-sm text-gray-500 mt-0.5">Skema Diikuti</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-green-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#16A34A" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $kompeten }}</p>
        <p class="text-sm text-gray-500 mt-0.5">Kompeten</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#EA580C" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $jadwalCount }}</p>
        <p class="text-sm text-gray-500 mt-0.5">Jadwal Mendatang</p>
    </div>

    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#9333EA" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalSertifikat }}</p>
        <p class="text-sm text-gray-500 mt-0.5">Total Sertifikat</p>
    </div>
</div>

{{-- BERITA HARI INI --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-5">Berita & Informasi Terbaru</h3>
    @if($informasi->isEmpty())
        <p class="text-sm text-gray-400 text-center py-4">Belum ada informasi yang dipublikasikan</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
        $gradients = ['from-blue-500 to-blue-700', 'from-indigo-500 to-purple-600', 'from-purple-500 to-pink-500'];
        $badgeColors = [
            'Pengumuman' => 'bg-green-100 text-green-700',
            'Berita'     => 'bg-blue-100 text-blue-700',
            'Tips'       => 'bg-purple-100 text-purple-700',
            'Kerjasama'  => 'bg-orange-100 text-orange-700',
        ];
        @endphp
        @foreach($informasi as $idx => $info)
        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer">
            <div class="bg-gradient-to-br {{ $gradients[$idx % 3] }} h-36 flex items-center justify-center">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div class="p-4">
                <span class="inline-block {{ $badgeColors[$info->kategori] ?? 'bg-gray-100 text-gray-700' }} text-xs font-semibold px-3 py-1 rounded-full mb-2">
                    {{ $info->kategori }}
                </span>
                <h4 class="font-bold text-sm text-gray-900 mb-1 line-clamp-2">{{ $info->judul }}</h4>
                <p class="text-xs text-gray-500 line-clamp-2">{{ $info->isi }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection