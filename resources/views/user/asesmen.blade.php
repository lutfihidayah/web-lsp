@extends('user.layout')
@section('title', 'Asesmen Saya')
@section('page-title', 'Asesmen Saya')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
@endif

@forelse($asesmens as $asesmen)
@php
    $totalAbsensi = $asesmen->absensi->count();
    $absensiHadir = $asesmen->absensi->where('status', 'hadir')->count();
    $absensiKonfirmasi = $asesmen->absensi->where('status', 'hadir')->where('dikonfirmasi_oleh', 'admin')->count();
    $progressAbsensi = $totalAbsensi > 0 ? ($absensiHadir / $totalAbsensi) * 100 : 0;
    $statusColor = match($asesmen->status) {
        'berlangsung' => 'bg-blue-100 text-blue-700',
        'selesai' => 'bg-yellow-100 text-yellow-700',
        'lulus' => 'bg-green-100 text-green-700',
        'tidak_lulus' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-600',
    };
@endphp
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    {{-- Header --}}
    <div class="flex items-start justify-between mb-5">
        <div>
            <h3 class="font-bold text-gray-900 text-lg">{{ $asesmen->pendaftaran->skema->nama ?? '-' }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $asesmen->pendaftaran->skema->kategori ?? '-' }} • Mulai {{ $asesmen->created_at->format('d M Y') }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
            {{ ucfirst(str_replace('_', ' ', $asesmen->status)) }}
        </span>
    </div>

    {{-- Progress --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-xs text-blue-600 font-medium mb-1">Absensi</p>
            <p class="text-xl font-bold text-gray-900">{{ $absensiHadir }}/{{ $totalAbsensi }}</p>
            <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressAbsensi }}%"></div>
            </div>
        </div>
        <div class="bg-purple-50 rounded-xl p-4">
            <p class="text-xs text-purple-600 font-medium mb-1">Dikonfirmasi Admin</p>
            <p class="text-xl font-bold text-gray-900">{{ $absensiKonfirmasi }}/{{ $totalAbsensi }}</p>
            <div class="w-full bg-purple-200 rounded-full h-2 mt-2">
                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $totalAbsensi > 0 ? ($absensiKonfirmasi / $totalAbsensi) * 100 : 0 }}%"></div></div>
            </div>
        </div>
        <div class="bg-green-50 rounded-xl p-4">
            <p class="text-xs text-green-600 font-medium mb-1">Quiz Final</p>
            @if($asesmen->nilai_quiz !== null)
                <p class="text-xl font-bold text-gray-900">{{ $asesmen->nilai_quiz }}%</p>
                <p class="text-xs mt-1 {{ $asesmen->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $asesmen->nilai_quiz >= 60 ? '✅ Lulus' : '❌ Tidak Lulus' }}
                </p>
            @else
                <p class="text-xl font-bold text-gray-400">Belum</p>
                <p class="text-xs text-gray-400 mt-1">Selesaikan absensi dulu</p>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('user.asesmen.show', $asesmen->id) }}" class="px-5 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            Lihat Detail & Absensi
        </a>
        @if($asesmen->status === 'lulus' && $asesmen->no_sertifikat)
        <a href="{{ route('user.asesmen.sertifikat', $asesmen->id) }}" class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Lihat Sertifikat
        </a>
        @endif
    </div>
</div>
@empty
<div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="1" class="mx-auto mb-4"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    <p class="text-gray-400 font-medium">Belum ada asesmen</p>
    <p class="text-sm text-gray-400 mt-1">Daftar dan bayar skema sertifikasi terlebih dahulu</p>
    <a href="{{ route('user.skema') }}" class="inline-block mt-4 px-5 py-2 bg-[#1e3a6e] text-white text-sm rounded-lg hover:bg-[#16305c] transition">Lihat Skema</a>
</div>
@endforelse

@endsection
