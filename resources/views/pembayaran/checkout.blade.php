@extends('layouts.app')
@section('title', 'Checkout - ' . $skema->nama)
@section('page-title', 'Pembayaran')

@section('content')

{{-- BACK BUTTON --}}
<div class="mb-5">
    <a href="{{ route('skema.show', $skema->id) }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Detail Skema
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Ringkasan Order --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header Card --}}
        <div class="bg-gradient-to-br from-[#1e3a6e] to-blue-600 rounded-2xl p-6 text-white">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-200 text-xs font-medium">Pendaftaran Sertifikasi</p>
                    <h2 class="text-lg font-bold">{{ $skema->nama }}</h2>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-blue-500">
                <div>
                    <p class="text-blue-200 text-xs">Kategori</p>
                    <p class="text-sm font-semibold mt-1">{{ $skema->kategori }}</p>
                </div>
                <div>
                    <p class="text-blue-200 text-xs">Durasi</p>
                    <p class="text-sm font-semibold mt-1">{{ $skema->durasi }}</p>
                </div>
                <div>
                    <p class="text-blue-200 text-xs">Unit Kompetensi</p>
                    <p class="text-sm font-semibold mt-1">{{ $skema->unit_kompetensi }} Unit</p>
                </div>
            </div>
        </div>

        {{-- Detail Pembayaran --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Detail Pembayaran
            </h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Order ID</span>
                    <span class="text-sm font-mono font-bold text-gray-800">{{ $pendingOrder->order_id }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Biaya Pendaftaran</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $skema->formatted_harga }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Biaya Admin</span>
                    <span class="text-sm font-semibold text-green-600">Gratis</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-base font-bold text-gray-900">Total Pembayaran</span>
                    <span class="text-xl font-bold text-[#1e3a6e]">{{ $pendingOrder->formatted_amount }}</span>
                </div>
            </div>
        </div>

        {{-- Info Peserta --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                Data Peserta
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">No. Telepon</p>
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->no_telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Tanggal Daftar</p>
                    <p class="text-sm font-semibold text-gray-800">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: Panel Bayar --}}
    <div class="space-y-5">

        {{-- Total & Bayar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-1">Total yang harus dibayar</p>
                <p class="text-3xl font-bold text-[#1e3a6e]">{{ $pendingOrder->formatted_amount }}</p>
            </div>

            {{-- Tombol Bayar Midtrans --}}
            <button id="pay-button"
                class="w-full bg-gradient-to-r from-[#1e3a6e] to-blue-600 text-white py-3.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-blue-200 transition-all duration-300 flex items-center justify-center gap-2 group">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="group-hover:scale-110 transition-transform">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Bayar Sekarang
            </button>

            @if(!config('midtrans.is_production'))
            {{-- TOMBOL SIMULASI (hanya tampil di Sandbox/Development) --}}
            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                <p class="text-xs font-bold text-yellow-700 mb-2 flex items-center gap-1">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Mode Sandbox — Testing Only
                </p>
                <form action="{{ route('pembayaran.simulate', $pendingOrder->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-yellow-500 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-yellow-600 transition flex items-center justify-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        ⚡ Simulasi Pembayaran Sukses
                    </button>
                </form>
                <p class="text-xs text-yellow-600 mt-1.5 text-center">Tanpa perlu bayar — hanya untuk testing</p>
            </div>
            @endif

            <div class="mt-4 p-3 bg-green-50 rounded-xl flex items-start gap-2">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2" class="flex-shrink-0 mt-0.5">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <p class="text-xs text-green-700">Pembayaran diproses secara aman melalui <strong>Midtrans</strong>. Tersedia berbagai metode: transfer bank, e-wallet, kartu kredit.</p>
            </div>

            <div class="mt-4 space-y-2">
                <p class="text-xs text-gray-400 text-center font-medium mb-2">Metode Pembayaran Tersedia</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach(['BCA', 'BNI', 'Mandiri', 'GoPay', 'OVO', 'QRIS'] as $method)
                    <div class="bg-gray-50 rounded-lg py-1.5 text-center">
                        <span class="text-xs text-gray-600 font-medium">{{ $method }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Syarat & Ketentuan --}}
        <div class="bg-blue-50 rounded-2xl p-4">
            <h4 class="text-xs font-bold text-blue-800 mb-2">Informasi Penting</h4>
            <ul class="space-y-1.5">
                <li class="text-xs text-blue-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span>
                    Pembayaran berlaku selama 24 jam
                </li>
                <li class="text-xs text-blue-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span>
                    Setelah bayar, jadwal asesmen otomatis ditentukan
                </li>
                <li class="text-xs text-blue-600 flex items-start gap-1.5">
                    <span class="mt-0.5">•</span>
                    Invoice dikirim ke email setelah pembayaran
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Midtrans Snap.js --}}
@php
    $snapUrl = config('midtrans.is_production')
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp
<script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
            <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4l3-3-3-3V0a12 12 0 100 24v-4l-3 3 3 3v-4a8 8 0 01-8-8z"></path>
        </svg> Memproses...`;

        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = '{{ route('pembayaran.callback') }}?order_id=' + result.order_id + '&status_code=200&transaction_status=settlement';
            },
            onPending: function (result) {
                alert('Pembayaran pending. Silakan selesaikan pembayaran Anda.');
                btn.disabled = false;
                btn.innerHTML = 'Bayar Sekarang';
            },
            onError: function (result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = 'Bayar Sekarang';
            },
            onClose: function () {
                btn.disabled = false;
                btn.innerHTML = `<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg> Bayar Sekarang`;
            }
        });
    });
</script>

@endsection
