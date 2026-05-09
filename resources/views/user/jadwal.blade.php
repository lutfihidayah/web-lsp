@extends('user.layout')
@section('title', 'Jadwal Asesmen Saya')
@section('page-title', 'Jadwal Asesmen')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Jadwal Asesmen Saya</h2>
    <p class="text-sm text-gray-500 mt-1">Jadwal asesmen yang terdaftar untuk akun Anda</p>
</div>

{{-- Jadwal Mendatang Cards --}}
@if($jadwalMendatang->isNotEmpty())
<div class="mb-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
        Jadwal Terdekat
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($jadwalMendatang as $jm)
        <div class="bg-gradient-to-br from-[#1e3a6e] to-blue-600 text-white rounded-xl p-5">
            <p class="text-xs text-blue-200 font-medium mb-2">{{ $jm->skema->nama ?? '-' }}</p>
            <p class="text-lg font-bold">{{ \Carbon\Carbon::parse($jm->tanggal)->format('d M Y') }}</p>
            <p class="text-sm text-blue-200 mt-1">{{ $jm->waktu }}</p>
            <div class="mt-3 pt-3 border-t border-blue-500 flex items-center justify-between text-xs text-blue-200">
                <span>📍 {{ $jm->lokasi }}</span>
                <span>👤 {{ $jm->asesor }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Tabel Jadwal Milik User --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-bold text-gray-900 mb-5">Semua Jadwal Terdaftar</h3>

    @if($jadwals->isEmpty())
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium text-base">Belum ada jadwal asesmen</p>
            <p class="text-gray-400 text-sm mt-1 mb-6">
                Daftar skema sertifikasi dan selesaikan pembayaran untuk mendapatkan jadwal asesmen.
            </p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('user.skema') }}"
                    class="inline-flex items-center gap-2 bg-[#1e3a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    </svg>
                    Lihat Daftar Skema
                </a>
                <a href="{{ route('user.pembayaran') }}"
                    class="inline-flex items-center gap-2 border border-gray-300 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
                    Riwayat Pembayaran
                </a>
            </div>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">Skema Sertifikasi</th>
                    <th class="text-left pb-3 font-medium">Tanggal</th>
                    <th class="text-left pb-3 font-medium">Waktu</th>
                    <th class="text-left pb-3 font-medium">Lokasi</th>
                    <th class="text-left pb-3 font-medium">Asesor</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $colors = [
                    'Selesai'     => 'bg-green-100 text-green-700',
                    'Berlangsung' => 'bg-blue-100 text-blue-700',
                    'Terjadwal'   => 'bg-yellow-100 text-yellow-700',
                    'Dibatalkan'  => 'bg-red-100 text-red-700',
                ];
                @endphp
                @foreach($jadwals as $j)
                @php
                    $isUpcoming = \Carbon\Carbon::parse($j->tanggal)->isFuture();
                @endphp
                <tr class="hover:bg-gray-50 {{ $isUpcoming ? 'bg-blue-50/30' : '' }}">
                    <td class="py-3">
                        <div class="font-medium text-gray-800">{{ $j->skema->nama ?? '-' }}</div>
                        @if($isUpcoming && $j->status === 'Terjadwal')
                            <div class="text-xs text-blue-500 mt-0.5 font-medium">
                                {{ \Carbon\Carbon::parse($j->tanggal)->diffForHumans() }}
                            </div>
                        @endif
                    </td>
                    <td class="py-3 text-gray-500">
                        {{ \Carbon\Carbon::parse($j->tanggal)->format('d M, Y') }}
                    </td>
                    <td class="py-3 text-gray-500">{{ $j->waktu }}</td>
                    <td class="py-3 text-gray-500">{{ $j->lokasi }}</td>
                    <td class="py-3 text-gray-500">{{ $j->asesor }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$j->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $j->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection