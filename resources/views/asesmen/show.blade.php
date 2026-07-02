@extends('layouts.app')
@section('title', 'Detail Asesmen')
@section('page-title', 'Detail Asesmen Peserta')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">{{ session('error') }}</div>
@endif

<div class="mb-5">
    <a href="{{ route('asesmen.index') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Monitoring
    </a>
</div>

{{-- Info Peserta --}}
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $asesmen->pendaftaran->user->name ?? '-' }}</h2>
            <p class="text-sm text-gray-500">{{ $asesmen->pendaftaran->user->email ?? '-' }}</p>
            <p class="text-sm text-gray-500 mt-1">Skema: <strong>{{ $asesmen->pendaftaran->skema->nama ?? '-' }}</strong></p>
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
    <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4">
        <p class="text-green-700 font-bold">Peserta LULUS</p>
        <p class="text-sm text-green-600 mt-1">No. Sertifikat: {{ $asesmen->no_sertifikat }} &bull; Nilai: {{ $asesmen->nilai_quiz }}%</p>
    </div>
    @endif
</div>

{{-- Absensi --}}
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
        <h3 class="font-bold text-gray-900 flex items-center gap-2">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Absensi ({{ $asesmen->absensi->where('dikonfirmasi_oleh', 'admin')->count() }}/10 dikonfirmasi)
        </h3>

        @php
            $pendingKonfirmasi = $asesmen->absensi->where('status', 'hadir')->filter(function($a) {
                return $a->dikonfirmasi_oleh !== 'admin';
            })->count();
        @endphp

        @if($pendingKonfirmasi > 0)
        <form action="{{ route('asesmen.konfirmasi-semua', $asesmen->id) }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition">
                Konfirmasi Semua ({{ $pendingKonfirmasi }})
            </button>
        </form>
        @endif
    </div>

    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm min-w-[800px]">
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
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Belum</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($abs->dikonfirmasi_oleh === 'admin')
                            <span class="text-xs text-green-600 font-medium">&#10003; Dikonfirmasi</span>
                        @elseif($abs->dikonfirmasi_oleh === 'user')
                            <span class="text-xs text-yellow-600 font-medium">Menunggu konfirmasi</span>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($abs->status === 'hadir' && $abs->dikonfirmasi_oleh !== 'admin')
                        <form action="{{ route('asesmen.konfirmasi', $abs->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition">
                                Konfirmasi
                            </button>
                        </form>
                        @else
                            <span class="text-xs text-gray-400">&mdash;</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Quiz Results --}}
@if($asesmen->quizJawaban->count() > 0)
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h3 class="font-bold text-gray-900 mb-4">Hasil Quiz — Nilai: 
        <span class="{{ $asesmen->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $asesmen->nilai_quiz }}%</span>
    </h3>

    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm min-w-[800px]">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Soal</th>
                    <th class="text-left pb-3 font-medium">Jawaban</th>
                    <th class="text-left pb-3 font-medium">Benar</th>
                    <th class="text-left pb-3 font-medium">Hasil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($asesmen->quizJawaban as $index => $qj)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $index + 1 }}</td>
                    <td class="py-3 text-gray-700 max-w-xs truncate">{{ $qj->soal->pertanyaan ?? '-' }}</td>
                    <td class="py-3 font-mono uppercase text-gray-600">{{ $qj->jawaban_user }}</td>
                    <td class="py-3 font-mono uppercase text-gray-600">{{ $qj->soal->jawaban_benar ?? '-' }}</td>
                    <td class="py-3">
                        @if($qj->is_benar)
                            <span class="text-green-600 font-bold">&#10003;</span>
                        @else
                            <span class="text-red-600 font-bold">&#10007;</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
