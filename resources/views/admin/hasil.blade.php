@extends('admin.layout')

@section('title', 'Hasil Sertifikasi')
@section('page-title', 'Hasil Sertifikasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Hasil Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total {{ $hasil->count() }} hasil sertifikasi</p>
        </div>
        <a href="{{ route('admin.hasil.create') }}" class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Hasil
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
            <p class="text-sm text-green-600 font-medium">Kompeten</p>
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

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Nama Peserta</th>
                    <th class="text-left pb-3 font-medium">Skema</th>
                    <th class="text-left pb-3 font-medium">Tanggal Asesmen</th>
                    <th class="text-left pb-3 font-medium">Asesor</th>
                    <th class="text-left pb-3 font-medium">Nilai</th>
                    <th class="text-left pb-3 font-medium">Hasil</th>
                    <th class="text-left pb-3 font-medium">No Sertifikat</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $colors = [
                    'Kompeten'       => 'bg-green-100 text-green-700',
                    'Belum Kompeten' => 'bg-red-100 text-red-700',
                    'Dalam Proses'   => 'bg-yellow-100 text-yellow-700',
                ];
                @endphp

                @forelse($hasil as $h)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $h->peserta->nama ?? '-' }}</td>
                    <td class="py-3 text-gray-500">{{ $h->peserta->skema->nama ?? $h->jadwal->skema->nama ?? '-' }}</td>
                    <td class="py-3 text-gray-500">{{ \Carbon\Carbon::parse($h->jadwal->tanggal ?? now())->format('d M, Y') }}</td>
                    <td class="py-3 text-gray-500">{{ $h->asesor }}</td>
                    <td class="py-3 text-gray-500">{{ $h->nilai ?? '-' }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$h->hasil] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $h->hasil }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500 font-mono text-xs">{{ $h->no_sertifikat ?? '-' }}</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.hasil.edit', $h->id) }}" class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.hasil.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    <td colspan="9" class="py-8 text-center text-gray-400">Belum ada data hasil sertifikasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection