@extends('user.layout')
@section('title', 'Detail Asesmen')
@section('page-title', 'Detail Asesmen')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">{{ session('error') }}</div>
@endif

<div class="mb-5">
    <a href="{{ route('user.asesmen') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Daftar Asesmen
    </a>
</div>

@php
    $totalAbsensi = $asesmen->absensi->count();
    $absensiKonfirmasi = $asesmen->absensi->where('status', 'hadir')->where('dikonfirmasi_oleh', 'admin')->count();
    $quizReady = $absensiKonfirmasi >= $totalAbsensi && $totalAbsensi > 0;
    $quizDone = $asesmen->quizJawaban->count() > 0;
@endphp

{{-- Info Card --}}
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $asesmen->pendaftaran->skema->nama }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $asesmen->pendaftaran->skema->kategori }}</p>
        </div>
        @php
            $statusColor = match($asesmen->status) {
                'berlangsung' => 'bg-blue-100 text-blue-700',
                'lulus' => 'bg-green-100 text-green-700',
                'tidak_lulus' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-600',
            };
        @endphp
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
            {{ ucfirst(str_replace('_', ' ', $asesmen->status)) }}
        </span>
    </div>

    @if($asesmen->status === 'lulus')
    <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
        <div>
            <p class="text-green-700 font-bold">🎉 Selamat! Anda dinyatakan LULUS</p>
            <p class="text-sm text-green-600 mt-1">No. Sertifikat: {{ $asesmen->no_sertifikat }} • Nilai: {{ $asesmen->nilai_quiz }}%</p>
        </div>
        <a href="{{ route('user.asesmen.sertifikat', $asesmen->id) }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition font-medium">
            Lihat Sertifikat
        </a>
    </div>
    @elseif($asesmen->status === 'tidak_lulus')
    <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-red-700 font-bold">Anda dinyatakan Tidak Lulus</p>
        <p class="text-sm text-red-600 mt-1">Nilai: {{ $asesmen->nilai_quiz }}% (minimum 60%). Hubungi admin untuk informasi lebih lanjut.</p>
    </div>
    @endif
</div>

{{-- Absensi Table --}}
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        Absensi Pertemuan ({{ $asesmen->absensi->where('status', 'hadir')->count() }}/{{ $totalAbsensi }})
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">Pertemuan</th>
                    <th class="text-left pb-3 font-medium">Tanggal</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                    <th class="text-left pb-3 font-medium">Konfirmasi</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($asesmen->absensi as $abs)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 font-medium text-gray-800">Pertemuan {{ $abs->pertemuan_ke }}</td>
                    <td class="py-3 text-gray-500">{{ $abs->tanggal ? $abs->tanggal->format('d M Y') : '-' }}</td>
                    <td class="py-3">
                        @if($abs->status === 'hadir')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Hadir</span>
                        @elseif($abs->status === 'tidak_hadir')
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Tidak Hadir</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Belum</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($abs->dikonfirmasi_oleh === 'admin')
                            <span class="text-xs text-green-600 font-medium">✅ Admin</span>
                        @elseif($abs->dikonfirmasi_oleh === 'user')
                            <span class="text-xs text-yellow-600 font-medium">⏳ Menunggu Admin</span>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($abs->status === 'belum')
                            <form action="{{ route('user.asesmen.hadir', $abs->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-[#1e3a6e] text-white text-xs rounded-lg hover:bg-[#16305c] transition font-medium">
                                    Hadir
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Quiz Section --}}
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Quiz Final
    </h3>

    @if($quizDone)
        {{-- Hasil Quiz --}}
        <div class="bg-gray-50 rounded-xl p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="font-medium text-gray-700">Hasil Quiz Anda</p>
                <span class="text-2xl font-bold {{ $asesmen->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $asesmen->nilai_quiz }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="h-3 rounded-full {{ $asesmen->nilai_quiz >= 60 ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $asesmen->nilai_quiz }}%"></div>
            </div>
            <p class="text-sm mt-2 {{ $asesmen->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">
                {{ $asesmen->nilai_quiz >= 60 ? '✅ Anda Lulus! Minimum 60%.' : '❌ Tidak Lulus. Minimum 60%.' }}
            </p>
            <p class="text-xs text-gray-400 mt-2">Jawaban benar: {{ $asesmen->quizJawaban->where('is_benar', true)->count() }}/{{ $asesmen->quizJawaban->count() }}</p>
        </div>
    @elseif($quizReady)
        {{-- Quiz Available --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-center">
            <p class="text-blue-700 font-medium mb-2">🎯 Quiz tersedia!</p>
            <p class="text-sm text-blue-600 mb-4">Semua absensi telah dikonfirmasi admin. Anda dapat mengerjakan quiz final sekarang.</p>
            <a href="{{ route('user.asesmen.quiz', $asesmen->id) }}" class="inline-block px-6 py-3 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] transition">
                Mulai Quiz Sekarang
            </a>
        </div>
    @else
        {{-- Quiz Locked --}}
        <div class="bg-gray-50 rounded-xl p-5 text-center">
            <p class="text-gray-500 font-medium mb-2">🔒 Quiz Terkunci</p>
            <p class="text-sm text-gray-400">Selesaikan semua absensi dan tunggu konfirmasi admin untuk membuka quiz.</p>
            <p class="text-xs text-gray-400 mt-2">Progress: {{ $absensiKonfirmasi }}/{{ $totalAbsensi }} dikonfirmasi admin</p>
        </div>
    @endif
</div>

@endsection
