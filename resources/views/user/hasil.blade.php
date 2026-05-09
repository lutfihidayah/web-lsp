@extends('user.layout')
@section('title', 'Hasil Sertifikasi')
@section('page-title', 'Hasil Sertifikasi')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Hasil Sertifikasi Saya</h2>
    <p class="text-sm text-gray-500 mt-1">Lihat hasil asesmen dan unduh sertifikat kompetensi Anda</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <p class="text-sm text-green-600 font-medium">Kompeten</p>
        <p class="text-3xl font-bold text-green-700 mt-1">{{ $kompeten }}</p>
    </div>
    <div class="bg-red-50 rounded-xl p-5 border border-red-100">
        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-3">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <p class="text-sm text-red-600 font-medium">Belum Kompeten</p>
        <p class="text-3xl font-bold text-red-700 mt-1">{{ $belumKompeten }}</p>
    </div>
    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mb-3">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#ca8a04" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <p class="text-sm text-yellow-600 font-medium">Dalam Proses</p>
        <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $dalamProses }}</p>
    </div>
</div>

{{-- Tabel Hasil --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-bold text-gray-900 mb-5">Riwayat Hasil Asesmen</h3>

    @if($asesmens->isEmpty())
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada hasil sertifikasi</p>
            <p class="text-gray-400 text-sm mt-1 mb-5">Data akan muncul setelah mengikuti asesmen</p>
            <a href="{{ route('user.skema') }}"
                class="inline-flex items-center gap-2 bg-[#1e3a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
                Daftar Skema Sekarang
            </a>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">Skema</th>
                    <th class="text-left pb-3 font-medium">Tanggal</th>
                    <th class="text-left pb-3 font-medium">Nilai Quiz</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                    <th class="text-left pb-3 font-medium">No. Sertifikat</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $colors = [
                    'lulus'        => 'bg-green-100 text-green-700',
                    'tidak_lulus'  => 'bg-red-100 text-red-700',
                    'berlangsung'  => 'bg-yellow-100 text-yellow-700',
                ];
                $labels = [
                    'lulus'        => 'Kompeten',
                    'tidak_lulus'  => 'Belum Kompeten',
                    'berlangsung'  => 'Dalam Proses',
                ];
                @endphp
                @foreach($asesmens as $a)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 font-medium text-gray-800">
                        {{ $a->pendaftaran->skema->nama ?? '-' }}
                    </td>
                    <td class="py-3 text-gray-500">
                        {{ $a->sertifikat_dibuat_at ? $a->sertifikat_dibuat_at->format('d M, Y') : $a->created_at->format('d M, Y') }}
                    </td>
                    <td class="py-3 text-gray-500">
                        @if($a->nilai_quiz !== null)
                            <span class="font-semibold text-gray-800">{{ $a->nilai_quiz }}</span>
                            <span class="text-gray-400">/100</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$a->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $labels[$a->status] ?? ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500 font-mono text-xs">
                        @if($a->no_sertifikat)
                            <span class="text-green-700 font-semibold">{{ $a->no_sertifikat }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($a->status === 'lulus')
                            <a href="{{ route('user.hasil.sertifikat', $a->id) }}"
                                target="_blank"
                                class="inline-flex items-center gap-1.5 bg-green-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 transition">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Lihat Sertifikat
                            </a>
                        @elseif($a->status === 'berlangsung')
                            <a href="{{ route('user.asesmen.show', $a->id) }}"
                                class="text-xs text-[#1e3a6e] font-medium hover:underline">Lihat Progress</a>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection