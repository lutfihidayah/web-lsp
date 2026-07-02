@extends('layouts.app')
@section('title', 'Invoice - ' . $pendaftaran->order_id)
@section('page-title', 'Invoice Pembayaran')

@section('content')

{{-- Action Buttons (non-print) --}}
<div class="flex items-center justify-between mb-6 no-print">
    <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali
    </a>
    <div class="flex gap-3">
        <button onclick="window.print()"
            class="flex items-center gap-2 bg-[#1e3a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Cetak Invoice
        </button>
    </div>
</div>

{{-- INVOICE DOCUMENT --}}
<div id="invoice-doc" class="bg-white rounded-2xl border border-gray-100 shadow-sm max-w-3xl mx-auto overflow-hidden">

    {{-- Invoice Header --}}
    <div class="bg-gradient-to-r from-[#1e3a6e] to-blue-700 p-8 text-white">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <svg width="20" height="20" viewBox="0 0 16 16" fill="#1e3a6e">
                            <rect x="1" y="1" width="6" height="6" rx="1"/>
                            <rect x="9" y="1" width="6" height="6" rx="1"/>
                            <rect x="1" y="9" width="6" height="6" rx="1"/>
                            <rect x="9" y="9" width="6" height="6" rx="1"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">LSP Profesional</h1>
                        <p class="text-blue-200 text-xs">Lembaga Sertifikasi Profesi</p>
                    </div>
                </div>
                <p class="text-blue-200 text-xs">Jl. Profesional No. 1, Indonesia</p>
                <p class="text-blue-200 text-xs">info@lspprofesional.id | +62 21 1234 5678</p>
            </div>
            <div class="text-right">
                <p class="text-blue-200 text-xs font-medium uppercase tracking-widest mb-1">Invoice</p>
                <p class="text-2xl font-bold font-mono">#{{ $pendaftaran->order_id }}</p>
                <div class="mt-3">
                    @if($pendaftaran->status === 'paid')
                        <span class="bg-green-400 text-green-900 text-xs font-bold px-3 py-1 rounded-full">LUNAS</span>
                    @elseif($pendaftaran->status === 'pending')
                        <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full">MENUNGGU</span>
                    @else
                        <span class="bg-red-400 text-red-900 text-xs font-bold px-3 py-1 rounded-full">{{ strtoupper($pendaftaran->status) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="p-8">

        {{-- Billing Info --}}
        <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-100">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Ditagihkan Kepada</p>
                <p class="font-bold text-gray-900 text-base">{{ $pendaftaran->user->name }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $pendaftaran->user->email }}</p>
                @if($pendaftaran->user->no_telepon)
                    <p class="text-sm text-gray-500">{{ $pendaftaran->user->no_telepon }}</p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Detail Invoice</p>
                <div class="space-y-1.5">
                    <div class="flex justify-end gap-6">
                        <span class="text-sm text-gray-500">Tanggal Invoice</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pendaftaran->created_at->format('d M Y') }}</span>
                    </div>
                    @if($pendaftaran->paid_at)
                    <div class="flex justify-end gap-6">
                        <span class="text-sm text-gray-500">Tanggal Bayar</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pendaftaran->paid_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($pendaftaran->payment_type)
                    <div class="flex justify-end gap-6">
                        <span class="text-sm text-gray-500">Metode Bayar</span>
                        <span class="text-sm font-semibold text-gray-800">{{ strtoupper(str_replace('_', ' ', $pendaftaran->payment_type)) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Item Table --}}
        <div class="mb-8">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="border-b-2 border-gray-100">
                        <th class="text-left pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="text-center pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Qty</th>
                        <th class="text-right pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="text-right pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-50">
                        <td class="py-4">
                            <p class="font-semibold text-gray-900">Biaya Sertifikasi</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $pendaftaran->skema->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Kategori: {{ $pendaftaran->skema->kategori ?? '-' }} • {{ $pendaftaran->skema->durasi ?? '-' }}</p>
                        </td>
                        <td class="py-4 text-center text-sm text-gray-600">1</td>
                        <td class="py-4 text-right text-sm text-gray-600">{{ $pendaftaran->formatted_amount }}</td>
                        <td class="py-4 text-right text-sm font-semibold text-gray-900">{{ $pendaftaran->formatted_amount }}</td>
                    </tr>
                    <tr class="border-b border-gray-50">
                        <td class="py-3">
                            <p class="text-sm text-gray-600">Biaya Admin</p>
                        </td>
                        <td class="py-3 text-center text-sm text-gray-600">1</td>
                        <td class="py-3 text-right text-sm text-gray-600">Rp 0</td>
                        <td class="py-3 text-right text-sm font-semibold text-green-600">Gratis</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div class="bg-gray-50 rounded-2xl p-5 mb-8">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Subtotal</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $pendaftaran->formatted_amount }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Diskon</span>
                    <span class="text-sm font-semibold text-green-600">Rp 0</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-200">
                    <span class="text-base font-bold text-gray-900">Total</span>
                    <span class="text-xl font-bold text-[#1e3a6e]">{{ $pendaftaran->formatted_amount }}</span>
                </div>
            </div>
        </div>

        {{-- Jadwal Asesmen --}}
        @if($pendaftaran->jadwal)
        <div class="bg-blue-50 rounded-2xl p-5 mb-8">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-wider mb-3">Jadwal Asesmen</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
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
        @endif

        {{-- Footer Note --}}
        <div class="border-t border-gray-100 pt-6">
            <p class="text-xs text-gray-400 text-center">
                Invoice ini diterbitkan secara otomatis oleh sistem LSP Profesional. Simpan invoice ini sebagai bukti pembayaran yang sah.<br>
                Jika ada pertanyaan, hubungi kami di <strong>info@lspprofesional.id</strong>
            </p>
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
    #invoice-doc {
        box-shadow: none !important;
        border: none !important;
        max-width: 100% !important;
    }
    @page { margin: 10mm; }
}
</style>

@endsection
