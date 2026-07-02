@extends('layouts.app')
@section('title', 'Hasil Sertifikasi')
@section('page-title', 'Hasil Sertifikasi')

@section('content')

@if(auth()->user()->role === 'admin')
{{-- ========== TAMPILAN ADMIN: TABLE SEMUA PESERTA ========== --}}

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Hasil Sertifikasi (Otomatis)</h2>
            <p class="text-sm text-gray-400">Total {{ $asesmens->count() }} peserta terdaftar · Data diperbarui otomatis</p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <div class="relative group">
                <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    Export
                </button>
                <div class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <button type="button" onclick="exportPDF()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</button>
                    <button type="button" onclick="exportExcel('Laporan_Hasil_Sertifikasi')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Stat Cards Admin --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
            <p class="text-sm text-green-600 font-medium">Kompeten (Lulus)</p>
            <p class="text-3xl font-bold text-green-700 mt-1">{{ $totalKompeten }}</p>
        </div>
        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
            <p class="text-sm text-red-600 font-medium">Belum Kompeten</p>
            <p class="text-3xl font-bold text-red-700 mt-1">{{ $totalBelumKompeten }}</p>
        </div>
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
            <p class="text-sm text-yellow-600 font-medium">Dalam Proses</p>
            <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $totalDalamProses }}</p>
        </div>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm min-w-[800px]">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Nama Peserta</th>
                    <th class="text-left pb-3 font-medium">Skema</th>
                    <th class="text-left pb-3 font-medium">Nilai Quiz</th>
                    <th class="text-left pb-3 font-medium">Hasil</th>
                    <th class="text-left pb-3 font-medium">No Sertifikat</th>
                    <th class="text-left pb-3 font-medium no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $colors = [
                    'lulus'       => 'bg-green-100 text-green-700',
                    'tidak_lulus' => 'bg-red-100 text-red-700',
                    'berlangsung' => 'bg-yellow-100 text-yellow-700',
                ];
                $labels = [
                    'lulus'       => 'Kompeten',
                    'tidak_lulus' => 'Belum Kompeten',
                    'berlangsung' => 'Dalam Proses',
                ];
                @endphp

                @forelse($asesmens as $a)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3">
                        <p class="font-medium text-gray-800">{{ $a->pendaftaran->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $a->pendaftaran->user->email ?? '-' }}</p>
                    </td>
                    <td class="py-3 text-gray-500">{{ $a->pendaftaran->skema->nama ?? '-' }}</td>
                    <td class="py-3">
                        @if($a->nilai_quiz !== null)
                            <span class="font-bold {{ $a->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $a->nilai_quiz }}%</span>
                        @else
                            <span class="text-gray-300 italic">Belum Quiz</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$a->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $labels[$a->status] ?? ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500 font-mono text-xs">{{ $a->no_sertifikat ?? '-' }}</td>
                    <td class="py-3 no-print">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('asesmen.show', $a->id) }}" class="px-3 py-1 bg-[#1e3a6e] text-white text-xs rounded-lg hover:bg-[#16305c] transition">Detail</a>
                            <form action="{{ route('hasil.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-red-500">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-gray-400">Belum ada peserta terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@else
{{-- ========== TAMPILAN USER: HASIL SENDIRI ========== --}}

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Hasil Sertifikasi Saya</h2>
    <p class="text-sm text-gray-500 mt-1">Lihat hasil asesmen dan unduh sertifikat kompetensi Anda</p>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
        <p class="text-sm text-green-600 font-medium">Kompeten</p>
        <p class="text-3xl font-bold text-green-700 mt-1">{{ $kompeten }}</p>
    </div>
    <div class="bg-red-50 rounded-xl p-5 border border-red-100">
        <p class="text-sm text-red-600 font-medium">Belum Kompeten</p>
        <p class="text-3xl font-bold text-red-700 mt-1">{{ $belumKompeten }}</p>
    </div>
    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
        <p class="text-sm text-yellow-600 font-medium">Dalam Proses</p>
        <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $dalamProses }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-bold text-gray-900 mb-5">Riwayat Hasil Asesmen</h3>

    @if($asesmens->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 font-medium">Belum ada hasil sertifikasi</p>
            <p class="text-gray-400 text-sm mt-1 mb-5">Data akan muncul setelah mengikuti asesmen</p>
            <a href="{{ route('skema.index') }}"
                class="inline-flex items-center gap-2 bg-[#1e3a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
                Daftar Skema Sekarang
            </a>
        </div>
    @else
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm min-w-[800px]">
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
                    'lulus'       => 'bg-green-100 text-green-700',
                    'tidak_lulus' => 'bg-red-100 text-red-700',
                    'berlangsung' => 'bg-yellow-100 text-yellow-700',
                ];
                $labels = [
                    'lulus'       => 'Kompeten',
                    'tidak_lulus' => 'Belum Kompeten',
                    'berlangsung' => 'Dalam Proses',
                ];
                @endphp
                @foreach($asesmens as $a)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 font-medium text-gray-800">{{ $a->pendaftaran->skema->nama ?? '-' }}</td>
                    <td class="py-3 text-gray-500">
                        {{ $a->sertifikat_dibuat_at ? $a->sertifikat_dibuat_at->format('d M, Y') : $a->created_at->format('d M, Y') }}
                    </td>
                    <td class="py-3 text-gray-500">
                        @if($a->nilai_quiz !== null)
                            <span class="font-semibold text-gray-800">{{ $a->nilai_quiz }}</span><span class="text-gray-400">/100</span>
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
                            <a href="{{ route('hasil.sertifikat', $a->id) }}" target="_blank"
                                class="inline-flex items-center gap-1.5 bg-green-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 transition">
                                Lihat Sertifikat
                            </a>
                        @elseif($a->status === 'berlangsung')
                            <a href="{{ route('asesmen.show', $a->id) }}"
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

@endif

@endsection