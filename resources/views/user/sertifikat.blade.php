@extends('user.layout')
@section('title', 'Sertifikat')
@section('page-title', 'Sertifikat')

@section('content')

<div class="mb-5">
    <a href="{{ route('user.asesmen') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Asesmen
    </a>
</div>

<div class="bg-white rounded-2xl border-2 border-[#1e3a6e] overflow-hidden shadow-lg max-w-3xl mx-auto" id="sertifikat">
    <div class="bg-gradient-to-r from-[#1e3a6e] to-[#2a5298] text-white p-8 text-center">
        <p class="text-sm uppercase tracking-widest text-blue-200 mb-2">Lembaga Sertifikasi Profesi</p>
        <h1 class="text-3xl font-bold">LSP <span class="text-orange-400">Profesional</span></h1>
        <p class="text-blue-200 text-sm mt-1">Terakreditasi BNSP</p>
    </div>

    <div class="p-10 text-center">
        <p class="text-gray-500 text-sm uppercase tracking-wider mb-4">Sertifikat Kompetensi</p>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $asesmen->pendaftaran->skema->nama }}</h2>
        <p class="text-sm text-gray-500 mb-8">{{ $asesmen->pendaftaran->skema->kategori }}</p>

        <p class="text-sm text-gray-600 mb-1">Diberikan kepada:</p>
        <h3 class="text-2xl font-bold text-[#1e3a6e] mb-6">{{ $asesmen->pendaftaran->user->name ?? auth()->user()->name }}</h3>

        <div class="grid grid-cols-3 gap-4 mb-8 max-w-lg mx-auto">
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-xs text-gray-400">No. Sertifikat</p>
                <p class="text-sm font-bold text-gray-800">{{ $asesmen->no_sertifikat }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-xs text-gray-400">Nilai</p>
                <p class="text-sm font-bold text-green-600">{{ $asesmen->nilai_quiz }}%</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-xs text-gray-400">Tanggal Terbit</p>
                <p class="text-sm font-bold text-gray-800">{{ $asesmen->sertifikat_dibuat_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <p class="text-xs text-gray-400">Sertifikat ini diterbitkan secara digital dan sah tanpa tanda tangan basah.</p>
            <p class="text-xs text-gray-400 mt-1">Berlaku selama 3 tahun sejak tanggal terbit.</p>
        </div>
    </div>

    <div class="bg-gray-50 px-8 py-4 flex items-center justify-between text-xs text-gray-400">
        <span>&copy; {{ date('Y') }} LSP Profesional</span>
        <span>ID: {{ $asesmen->no_sertifikat }}</span>
    </div>
</div>

<div class="text-center mt-6">
    <button onclick="window.print()" class="px-6 py-3 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] transition inline-flex items-center gap-2">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Cetak / Download PDF
    </button>
</div>

@endsection
