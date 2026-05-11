@extends('admin.layout')

@section('title', 'Hasil Sertifikasi')
@section('page-title', 'Hasil Sertifikasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Hasil Sertifikasi (Otomatis)</h2>
            <p class="text-sm text-gray-400">Total {{ $asesmens->count() }} peserta terdaftar</p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <div class="text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                * Data diperbarui otomatis dari hasil quiz & absensi
            </div>
            <div class="relative group">
                <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
                <div class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <button type="button" onclick="exportPDF()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Export PDF
                    </button>
                    <button type="button" onclick="exportExcel('Laporan_Hasil_Sertifikasi')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="17"/><line x1="16" y1="13" x2="8" y2="17"/></svg>
                        Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
            <p class="text-sm text-green-600 font-medium">Kompeten (Lulus)</p>
            <p class="text-3xl font-bold text-green-700 mt-1">{{ $totalKompeten }}</p>
        </div>
        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
            <p class="text-sm text-red-600 font-medium">Belum Kompeten (Gagal)</p>
            <p class="text-3xl font-bold text-red-700 mt-1">{{ $totalBelumKompeten }}</p>
        </div>
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
            <p class="text-sm text-yellow-600 font-medium">Dalam Proses</p>
            <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $totalDalamProses }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
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

                @forelse($asesmens as $a)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3">
                        <p class="font-medium text-gray-800">{{ $a->pendaftaran->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $a->pendaftaran->user->email ?? '-' }}</p>
                    </td>
                    <td class="py-3 text-gray-500">{{ $a->pendaftaran->skema->nama ?? '-' }}</td>
                    <td class="py-3 text-gray-500">
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
                    <td class="py-3 text-gray-500 font-mono text-xs">
                        {{ $a->no_sertifikat ?? '-' }}
                    </td>
                    <td class="py-3 no-print">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.asesmen.show', $a->id) }}" class="px-3 py-1 bg-[#1e3a6e] text-white text-xs rounded-lg hover:bg-[#16305c] transition" title="Detail Progress">
                                Detail
                            </a>
                            <form action="{{ route('admin.hasil.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-red-500" title="Hapus">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-400">Belum ada peserta terdaftar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection