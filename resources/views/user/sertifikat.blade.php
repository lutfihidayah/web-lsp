@extends('user.layout')
@section('title', 'Sertifikat Kompetensi')
@section('page-title', 'Sertifikat')

@section('content')

{{-- Action Buttons --}}
<div class="flex items-center justify-between mb-6 no-print">
    <a href="{{ route('user.hasil') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Hasil
    </a>
    <button onclick="window.print()"
        class="flex items-center gap-2 bg-[#1e3a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Cetak / Download PDF
    </button>
</div>

{{-- SERTIFIKAT DOCUMENT --}}
<div id="sertifikat-doc" class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl overflow-hidden shadow-lg" style="border: 8px solid #1e3a6e;">

        {{-- Inner border --}}
        <div style="border: 3px solid #c4a535; margin: 8px; border-radius: 8px; overflow: hidden;">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-[#1e3a6e] to-blue-800 px-10 py-8 text-center text-white">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center">
                        <svg width="28" height="28" viewBox="0 0 16 16" fill="#1e3a6e">
                            <rect x="1" y="1" width="6" height="6" rx="1"/>
                            <rect x="9" y="1" width="6" height="6" rx="1"/>
                            <rect x="1" y="9" width="6" height="6" rx="1"/>
                            <rect x="9" y="9" width="6" height="6" rx="1"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-blue-200 text-xs tracking-widest uppercase font-medium">Lembaga Sertifikasi Profesi</p>
                        <h1 class="text-2xl font-bold">LSP Profesional</h1>
                    </div>
                </div>
                <div class="border-t border-blue-600 pt-4">
                    <p class="text-xs text-blue-200 tracking-widest uppercase">Sertifikat Kompetensi</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-12 py-10 text-center">

                {{-- Gold ribbon --}}
                <div class="flex items-center justify-center gap-4 mb-8">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent to-yellow-500"></div>
                    <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #c4a535, #f0d060, #c4a535);">
                        <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 h-px bg-gradient-to-l from-transparent to-yellow-500"></div>
                </div>

                <p class="text-gray-500 text-sm mb-3 tracking-wider uppercase">Diberikan kepada</p>
                <h2 class="text-4xl font-bold text-[#1e3a6e] mb-1" style="font-family: Georgia, serif; letter-spacing: 1px;">
                    {{ $hasil->peserta->nama ?? auth()->user()->name }}
                </h2>
                <p class="text-gray-400 text-sm mb-8">{{ $hasil->peserta->email ?? auth()->user()->email }}</p>

                <p class="text-gray-600 text-sm mb-3">Telah dinyatakan</p>
                <div class="inline-block bg-green-50 border-2 border-green-400 rounded-xl px-8 py-3 mb-6">
                    <span class="text-2xl font-bold text-green-700">✓ KOMPETEN</span>
                </div>

                <p class="text-gray-600 text-sm mb-2">Dalam skema sertifikasi</p>
                <h3 class="text-xl font-bold text-gray-900 mb-1">
                    {{ $hasil->peserta->skema->nama ?? $hasil->jadwal->skema->nama ?? '-' }}
                </h3>
                <p class="text-sm text-gray-500 mb-8">
                    {{ $hasil->peserta->skema->kategori ?? '-' }} •
                    {{ $hasil->peserta->skema->unit_kompetensi ?? '-' }} Unit Kompetensi
                </p>

                {{-- Detail Grid --}}
                <div class="grid grid-cols-3 gap-6 mb-10">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1 uppercase tracking-wider">No. Sertifikat</p>
                        <p class="text-sm font-bold text-gray-800 font-mono">{{ $hasil->no_sertifikat ?? 'LSP-' . str_pad($hasil->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1 uppercase tracking-wider">Tanggal Asesmen</p>
                        <p class="text-sm font-bold text-gray-800">
                            {{ $hasil->jadwal ? \Carbon\Carbon::parse($hasil->jadwal->tanggal)->format('d M Y') : \Carbon\Carbon::parse($hasil->created_at)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 mb-1 uppercase tracking-wider">Asesor</p>
                        <p class="text-sm font-bold text-gray-800">{{ $hasil->asesor }}</p>
                    </div>
                </div>

                {{-- Nilai --}}
                @if($hasil->nilai)
                <div class="inline-flex items-center gap-2 bg-blue-50 rounded-xl px-6 py-3 mb-10">
                    <span class="text-sm text-blue-600">Nilai Asesmen:</span>
                    <span class="text-2xl font-bold text-blue-800">{{ $hasil->nilai }}</span>
                    <span class="text-sm text-blue-500">/ 100</span>
                </div>
                @endif

                {{-- Signature Area --}}
                <div class="flex items-end justify-between pt-8 border-t border-gray-100">
                    <div class="text-left">
                        <div class="w-32 h-12 border-b-2 border-gray-300 mb-2"></div>
                        <p class="text-xs font-semibold text-gray-700">Direktur LSP</p>
                        <p class="text-xs text-gray-400">LSP Profesional</p>
                    </div>
                    <div class="text-center">
                        {{-- QR Placeholder --}}
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-1 border border-gray-200">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="1">
                                <rect x="3" y="3" width="8" height="8"/><rect x="13" y="3" width="8" height="8"/>
                                <rect x="3" y="13" width="8" height="8"/><rect x="15" y="15" width="2" height="2"/>
                                <rect x="19" y="15" width="2" height="2"/><rect x="15" y="19" width="2" height="2"/>
                                <rect x="19" y="19" width="2" height="2"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400">Verifikasi</p>
                    </div>
                    <div class="text-right">
                        <div class="w-32 h-12 border-b-2 border-gray-300 mb-2 ml-auto"></div>
                        <p class="text-xs font-semibold text-gray-700">Ketua Asesor</p>
                        <p class="text-xs text-gray-400">{{ $hasil->asesor }}</p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-10 py-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-400">
                    Sertifikat ini diterbitkan oleh <strong>LSP Profesional</strong> dan berlaku sesuai ketentuan yang berlaku.
                    Verifikasi keabsahan sertifikat melalui <strong>lspprofesional.id</strong>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    aside, header { display: none !important; }
    .ml-60 { margin-left: 0 !important; }
    main { padding: 0 !important; }
    #sertifikat-doc { max-width: 100% !important; }
    @page { margin: 5mm; size: A4 landscape; }
}
</style>

@endsection
