@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')
@section('page-title', 'Pembayaran Berhasil')

@section('content')

<div class="max-w-2xl mx-auto py-8">

    {{-- Success Animation Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Top gradient band --}}
        <div class="h-2 bg-gradient-to-r from-green-400 to-emerald-500"></div>

        <div class="p-8 text-center">

            {{-- Animated Check Icon --}}
            <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-200" style="animation: bounceIn 0.6s ease;">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Berhasil! 🎉</h2>
            <p class="text-gray-500 text-sm mb-2">Selamat, <strong>{{ auth()->user()->name }}</strong>!</p>
            <p class="text-gray-500 text-sm mb-8">Pendaftaran sertifikasi Anda telah dikonfirmasi dan jadwal asesmen telah dijadwalkan.</p>

            {{-- Order Info Box --}}
            <div class="bg-gray-50 rounded-2xl p-5 text-left mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-[#1e3a6e] rounded-lg flex items-center justify-center">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900">Ringkasan Transaksi</span>
                </div>
                <div class="space-y-3 divide-y divide-gray-100">
                    <div class="flex justify-between pt-2">
                        <span class="text-sm text-gray-500">Order ID</span>
                        <span class="text-sm font-mono font-bold text-gray-800">{{ $pendaftaran->order_id }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-sm text-gray-500">Skema</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pendaftaran->skema->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-sm text-gray-500">Jumlah Dibayar</span>
                        <span class="text-sm font-bold text-green-600">{{ $pendaftaran->formatted_amount }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-sm text-gray-500">Tanggal Bayar</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pendaftaran->paid_at ? $pendaftaran->paid_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $pendaftaran->status_color }}">{{ $pendaftaran->status_label }}</span>
                    </div>
                </div>
            </div>

            {{-- Jadwal Asesmen Info --}}
            @if($pendaftaran->jadwal)
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 text-left mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="font-bold text-blue-900">Jadwal Asesmen Anda</span>
                    <span class="ml-auto text-xs bg-blue-100 text-blue-700 font-bold px-2 py-1 rounded-full">Otomatis Dijadwalkan</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-blue-400 mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-blue-900">{{ \Carbon\Carbon::parse($pendaftaran->jadwal->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-400 mb-1">Waktu</p>
                        <p class="text-sm font-bold text-blue-900">{{ $pendaftaran->jadwal->waktu }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-400 mb-1">Lokasi</p>
                        <p class="text-sm font-bold text-blue-900">{{ $pendaftaran->jadwal->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-400 mb-1">Asesor</p>
                        <p class="text-sm font-bold text-blue-900">{{ $pendaftaran->jadwal->asesor }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4 text-left mb-6">
                <div class="flex items-start gap-3">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2" class="flex-shrink-0 mt-0.5">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="text-sm text-yellow-800">Jadwal asesmen belum tersedia saat ini. Admin akan segera menginformasikan jadwal Anda melalui email.</p>
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex gap-3">
                <a href="{{ route('pembayaran.invoice', $pendaftaran->id) }}"
                    class="flex-1 bg-[#1e3a6e] text-white py-3 rounded-xl font-semibold text-sm hover:bg-[#16305c] transition flex items-center justify-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Lihat Invoice
                </a>
                <a href="{{ route('jadwal.index') }}"
                    class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-semibold text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Jadwal Asesmen
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes bounceIn {
    0% { transform: scale(0); opacity: 0; }
    60% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); }
}
</style>

@endsection
