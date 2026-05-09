@extends('user.layout')
@section('title', $skema->nama)
@section('page-title', 'Detail Skema')

@section('content')

{{-- BACK BUTTON --}}
<div class="mb-5">
    <a href="{{ route('user.skema') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Daftar Skema
    </a>
</div>

@php
    $kategoriColor = match($skema->kategori) {
        'Teknologi Informasi' => 'from-blue-500 to-blue-700',
        'Pemasaran Digital'   => 'from-purple-500 to-pink-500',
        'Administrasi'        => 'from-yellow-400 to-orange-400',
        'Desain'              => 'from-red-400 to-pink-500',
        default               => 'from-gray-400 to-gray-600',
    };

    // Cek apakah user sudah pernah daftar dan bayar skema ini
    $sudahBayar = auth()->check() ? \App\Models\Pendaftaran::where('user_id', auth()->id())
        ->where('skema_id', $skema->id)
        ->where('status', 'paid')
        ->first() : null;

    $pending = auth()->check() ? \App\Models\Pendaftaran::where('user_id', auth()->id())
        ->where('skema_id', $skema->id)
        ->where('status', 'pending')
        ->first() : null;
@endphp

{{-- Flash Messages --}}
@if(session('info'))
<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-3">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <p class="text-sm text-blue-700">{{ session('info') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2" class="flex-shrink-0 mt-0.5">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <div>
        <p class="text-sm font-semibold text-red-700">Gagal memproses pendaftaran</p>
        <p class="text-sm text-red-600 mt-1">{{ session('error') }}</p>
    </div>
</div>
@endif


<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- BANNER --}}
    <div class="h-48 bg-gradient-to-br {{ $kategoriColor }} flex items-center justify-center relative">
        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1">
            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
        </svg>
        <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
            {{ $skema->status }}
        </span>
    </div>

    <div class="p-8">

        {{-- JUDUL --}}
        <div class="mb-6">
            <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                {{ $skema->kategori }}
            </span>
            <h2 class="text-2xl font-bold text-gray-900 mt-3">{{ $skema->nama }}</h2>
            <p class="text-gray-500 mt-2 leading-relaxed">
                {{ $skema->deskripsi ?? 'Tidak ada deskripsi tersedia untuk skema ini.' }}
            </p>
        </div>

        {{-- INFO CARDS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="text-xs text-blue-500 font-medium mb-1">Lokasi</p>
                <p class="text-sm font-bold text-gray-800">Gedung LSP</p>
            </div>
            <div class="bg-green-50 rounded-xl p-4">
                <p class="text-xs text-green-500 font-medium mb-1">Total Peserta</p>
                <p class="text-sm font-bold text-gray-800">{{ $skema->peserta_count }} Peserta</p>
            </div>
            <div class="bg-purple-50 rounded-xl p-4">
                <p class="text-xs text-purple-500 font-medium mb-1">Biaya Sertifikasi</p>
                <p class="text-sm font-bold text-gray-800">{{ $skema->formatted_harga }}</p>
            </div>
            <div class="bg-orange-50 rounded-xl p-4">
                <p class="text-xs text-orange-500 font-medium mb-1">Durasi</p>
                <p class="text-sm font-bold text-gray-800">{{ $skema->durasi }}</p>
            </div>
        </div>

        {{-- UNIT KOMPETENSI --}}
        <div class="mb-8">
            <h3 class="font-bold text-gray-900 mb-3">Unit Kompetensi</h3>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-sm text-gray-600">Total <span class="font-bold text-gray-900">{{ $skema->unit_kompetensi }} unit kompetensi</span> yang harus dicapai dalam skema ini.</p>
            </div>
        </div>

        {{-- STATUS PENDAFTARAN / TOMBOL DAFTAR --}}
        <div class="flex items-center gap-3">

            @if($sudahBayar)
                {{-- Sudah Terdaftar --}}
                <div class="flex items-center gap-3 flex-1">
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-6 py-3 rounded-lg font-semibold text-sm">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Anda Sudah Terdaftar
                    </div>
                    <a href="{{ route('user.pembayaran.invoice', $sudahBayar->id) }}"
                        class="bg-[#1e3a6e] text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-[#16305c] transition flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Lihat Invoice
                    </a>
                </div>

            @elseif($pending)
                {{-- Ada Pending Payment --}}
                <div class="flex items-center gap-3 flex-1">
                    <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-3 rounded-lg font-semibold text-sm">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Menunggu Pembayaran
                    </div>
                    <a href="{{ route('user.pembayaran.checkout', $skema->id) }}"
                        class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-yellow-600 transition">
                        Selesaikan Pembayaran
                    </a>
                </div>

            @else
                {{-- Tombol Daftar --}}
                <button onclick="document.getElementById('modalDaftar').classList.remove('hidden')"
                    class="bg-[#1e3a6e] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#16305c] transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Daftar Skema Ini
                </button>
            @endif

            <a href="{{ route('user.skema') }}"
                class="border border-gray-300 text-gray-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI DAFTAR --}}
<div id="modalDaftar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-xl">

        {{-- Modal Header --}}
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="1.5">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Pendaftaran</h3>
            <p class="text-gray-500 text-sm">Anda akan mendaftar skema sertifikasi:</p>
            <p class="font-bold text-[#1e3a6e] mt-1">{{ $skema->nama }}</p>
        </div>

        {{-- Biaya --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Biaya Sertifikasi</span>
                <span class="text-lg font-bold text-[#1e3a6e]">{{ $skema->formatted_harga }}</span>
            </div>
            <div class="flex justify-between items-center mt-1">
                <span class="text-xs text-gray-400">Biaya Admin</span>
                <span class="text-xs text-green-600 font-medium">Gratis</span>
            </div>
        </div>

        <p class="text-xs text-gray-400 text-center mb-5">
            Anda akan diarahkan ke halaman pembayaran untuk menyelesaikan transaksi via Midtrans.
        </p>

        {{-- Action Form --}}
        <form action="{{ route('user.pembayaran.checkout', $skema->id) }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-[#1e3a6e] text-white py-3 rounded-xl font-bold hover:bg-[#16305c] transition text-sm flex items-center justify-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Ya, Lanjut Pembayaran
                </button>
                <button type="button" onclick="document.getElementById('modalDaftar').classList.add('hidden')"
                    class="flex-1 border border-gray-300 text-gray-600 py-3 rounded-xl font-semibold hover:bg-gray-50 transition text-sm">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection