@extends('layouts.app')
@section('title', $skema->nama)
@section('page-title', 'Detail Skema')

@section('content')

<div class="mb-5">
    <a href="{{ route('skema.index') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
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

    $sudahBayar = auth()->check() ? \App\Models\Pendaftaran::where('user_id', auth()->id())
        ->where('skema_id', $skema->id)
        ->where('status', 'paid')
        ->first() : null;

    $pending = auth()->check() ? \App\Models\Pendaftaran::where('user_id', auth()->id())
        ->where('skema_id', $skema->id)
        ->where('status', 'pending')
        ->first() : null;
@endphp

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

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
        <div class="mb-6">
            <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                {{ $skema->kategori }}
            </span>
            <h2 class="text-2xl font-bold text-gray-900 mt-3">{{ $skema->nama }}</h2>
            <p class="text-gray-500 mt-2 leading-relaxed">
                {{ $skema->deskripsi ?? 'Tidak ada deskripsi tersedia untuk skema ini.' }}
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="text-xs text-blue-500 font-medium mb-1">Lokasi</p>
                <p class="text-sm font-bold text-gray-800">Gedung Sertify</p>
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

        <div class="mb-8">
            <h3 class="font-bold text-gray-900 mb-3">Unit Kompetensi</h3>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-sm text-gray-600">Total <span class="font-bold text-gray-900">{{ $skema->unit_kompetensi }} unit kompetensi</span> yang harus dicapai dalam skema ini.</p>
            </div>
        </div>

        @if(auth()->user()->role === 'user')
        <div class="flex items-center gap-3">
            @if($sudahBayar)
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-6 py-3 rounded-lg font-semibold text-sm">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Anda Sudah Terdaftar
                </div>
                <a href="{{ route('pembayaran.invoice', $sudahBayar->id) }}"
                    class="bg-[#1e3a6e] text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-[#16305c] transition">
                    Lihat Invoice
                </a>

            @elseif($pending)
                <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-3 rounded-lg font-semibold text-sm">
                    Menunggu Pembayaran
                </div>
                <a href="{{ route('pembayaran.checkout', $skema->id) }}"
                    class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold text-sm hover:bg-yellow-600 transition">
                    Selesaikan Pembayaran
                </a>

            @else
                <button onclick="document.getElementById('modalDaftar').classList.remove('hidden')"
                    class="bg-[#1e3a6e] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#16305c] transition flex items-center gap-2">
                    Daftar Skema Ini
                </button>
            @endif

            <a href="{{ route('skema.index') }}"
                class="border border-gray-300 text-gray-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>
        @endif
    </div>
</div>

@if(auth()->user()->role === 'user')
<div id="modalDaftar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-xl">
        <div class="text-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Pendaftaran</h3>
            <p class="text-gray-500 text-sm">Anda akan mendaftar skema sertifikasi:</p>
            <p class="font-bold text-[#1e3a6e] mt-1">{{ $skema->nama }}</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Biaya Sertifikasi</span>
                <span class="text-lg font-bold text-[#1e3a6e]">{{ $skema->formatted_harga }}</span>
            </div>
        </div>

        <form action="{{ route('pembayaran.checkout', $skema->id) }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-[#1e3a6e] text-white py-3 rounded-xl font-bold hover:bg-[#16305c] transition text-sm">
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
@endif

@endsection
