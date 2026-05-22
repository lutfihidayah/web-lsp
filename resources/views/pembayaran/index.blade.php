@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Riwayat Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-1">Daftar semua transaksi pendaftaran sertifikasi Anda</p>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2">
        <polyline points="20 6 9 17 4 12"/>
    </svg>
    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
</div>
@endif

@if($pendaftarans->isEmpty())
    <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">Belum ada riwayat pembayaran</p>
        <p class="text-gray-400 text-sm mt-1 mb-5">Daftar skema sertifikasi untuk memulai</p>
        <a href="{{ route('skema.index') }}"
            class="inline-flex items-center gap-2 bg-[#1e3a6e] text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
            Lihat Daftar Skema
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($pendaftarans as $item)
        @php
            $statusColor = match($item->status) {
                'paid'    => 'bg-green-100 text-green-700 border-green-200',
                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                'failed'  => 'bg-red-100 text-red-700 border-red-200',
                'expired' => 'bg-gray-100 text-gray-600 border-gray-200',
                default   => 'bg-gray-100 text-gray-600 border-gray-200',
            };
            $statusLabel = match($item->status) {
                'paid'    => 'Lunas',
                'pending' => 'Menunggu Pembayaran',
                'failed'  => 'Gagal',
                'expired' => 'Kadaluarsa',
                default   => 'Unknown',
            };
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    {{-- Icon --}}
                    <div class="w-12 h-12 bg-gradient-to-br from-[#1e3a6e] to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
                        </svg>
                    </div>
                    {{-- Info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="font-bold text-gray-900 text-base">{{ $item->skema->nama ?? '-' }}</h4>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $statusColor }}">{{ $statusLabel }}</span>
                        </div>
                        <p class="text-xs text-gray-400 font-mono mb-2">{{ $item->order_id }}</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            @if($item->jadwal)
                            <span class="flex items-center gap-1 text-blue-600">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Asesmen: {{ \Carbon\Carbon::parse($item->jadwal->tanggal)->format('d M Y') }}
                            </span>
                            @endif
                            @if($item->payment_type)
                            <span>{{ strtoupper(str_replace('_', ' ', $item->payment_type)) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Right: Amount + Actions --}}
                <div class="text-right flex-shrink-0">
                    <p class="text-lg font-bold text-[#1e3a6e] mb-3">{{ $item->formatted_amount }}</p>
                    <div class="flex gap-2 justify-end">
                        @if($item->status === 'paid')
                            <a href="{{ route('pembayaran.invoice', $item->id) }}"
                                class="text-xs bg-[#1e3a6e] text-white px-3 py-1.5 rounded-lg font-medium hover:bg-[#16305c] transition flex items-center gap-1">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                Invoice
                            </a>
                        @elseif($item->status === 'pending')
                            <a href="{{ route('pembayaran.checkout', $item->skema_id) }}"
                                class="text-xs bg-yellow-500 text-white px-3 py-1.5 rounded-lg font-medium hover:bg-yellow-600 transition flex items-center gap-1">
                                Bayar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
