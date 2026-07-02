@extends('layouts.app')

@section('title', 'Bank Soal')
@section('page-title', 'Bank Soal')

@section('content')

<div class="space-y-6">

    {{-- KARTU KESIAPAN SKEMA --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-800 text-lg mb-4">Kesiapan Soal Per Skema</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($skemas as $sk)
                @php
                    $isReady = $sk->soals_count >= 10;
                @endphp
                <div class="border rounded-xl p-4 flex flex-col justify-between transition hover:shadow-sm {{ $isReady ? 'border-green-200 bg-green-50/30' : 'border-red-200 bg-red-50/30' }}">
                    <div>
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $isReady ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $sk->soals_count }} Soal
                            </span>
                            <span class="text-[10px] uppercase font-bold text-gray-400">
                                {{ $sk->kategori }}
                            </span>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm line-clamp-2" title="{{ $sk->nama }}">{{ $sk->nama }}</h3>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs {{ $isReady ? 'text-green-700 font-medium' : 'text-red-700 font-medium' }} flex items-center gap-1">
                            @if($isReady)
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Siap Diujikan
                            @else
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                Kurang {{ 10 - $sk->soals_count }} Soal
                            @endif
                        </span>
                        <a href="{{ route('soal.index', ['skema_id' => $sk->id]) }}" class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                            Lihat Soal &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MANAJEMEN DETAIL SOAL --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Daftar Pertanyaan Ujian</h2>
                <p class="text-sm text-gray-400">Kelola bank soal untuk kuis / asesmen online</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('soal.create') }}" class="px-4 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition inline-flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        {{-- FILTER & PENCARIAN --}}
        <form method="GET" action="{{ route('soal.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Filter Skema</label>
                <select name="skema_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                    <option value="">Semua Skema</option>
                    @foreach($skemas as $sk)
                        <option value="{{ $sk->id }}" {{ request('skema_id') == $sk->id ? 'selected' : '' }}>
                            {{ $sk->nama }} ({{ $sk->soals_count }} Soal)
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Cari Pertanyaan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." 
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition flex-1">
                    Cari & Filter
                </button>
                @if(request()->filled('skema_id') || request()->filled('search'))
                    <a href="{{ route('soal.index') }}" class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- TABLE DETAIL SOAL --}}
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm min-w-[800px]">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs">
                        <th class="text-left pb-3 font-medium w-12">No</th>
                        <th class="text-left pb-3 font-medium w-48">Skema Sertifikasi</th>
                        <th class="text-left pb-3 font-medium">Pertanyaan</th>
                        <th class="text-left pb-3 font-medium w-64">Pilihan Opsi</th>
                        <th class="text-left pb-3 font-medium w-24">Jawaban</th>
                        <th class="text-left pb-3 font-medium no-print w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($soals as $soal)
                        <tr class="hover:bg-gray-50/50">
                            <td class="py-4 text-gray-400 font-medium">
                                {{ ($soals->currentPage() - 1) * $soals->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-4 text-gray-500 font-medium pr-4">
                                <span class="line-clamp-2" title="{{ $soal->skema->nama ?? '-' }}">
                                    {{ $soal->skema->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 text-gray-800 font-medium pr-4">
                                <div class="font-medium text-gray-800 line-clamp-3" title="{{ $soal->pertanyaan }}">
                                    {{ $soal->pertanyaan }}
                                </div>
                            </td>
                            <td class="py-4 text-xs text-gray-600 space-y-1 pr-4">
                                <div class="flex items-start gap-1">
                                    <span class="font-bold {{ $soal->jawaban_benar === 'a' ? 'text-green-600' : 'text-gray-400' }}">A.</span>
                                    <span class="{{ $soal->jawaban_benar === 'a' ? 'text-green-700 font-bold bg-green-50 px-1 rounded' : '' }} line-clamp-1">{{ $soal->pilihan_a }}</span>
                                </div>
                                <div class="flex items-start gap-1">
                                    <span class="font-bold {{ $soal->jawaban_benar === 'b' ? 'text-green-600' : 'text-gray-400' }}">B.</span>
                                    <span class="{{ $soal->jawaban_benar === 'b' ? 'text-green-700 font-bold bg-green-50 px-1 rounded' : '' }} line-clamp-1">{{ $soal->pilihan_b }}</span>
                                </div>
                                <div class="flex items-start gap-1">
                                    <span class="font-bold {{ $soal->jawaban_benar === 'c' ? 'text-green-600' : 'text-gray-400' }}">C.</span>
                                    <span class="{{ $soal->jawaban_benar === 'c' ? 'text-green-700 font-bold bg-green-50 px-1 rounded' : '' }} line-clamp-1">{{ $soal->pilihan_c }}</span>
                                </div>
                                <div class="flex items-start gap-1">
                                    <span class="font-bold {{ $soal->jawaban_benar === 'd' ? 'text-green-600' : 'text-gray-400' }}">D.</span>
                                    <span class="{{ $soal->jawaban_benar === 'd' ? 'text-green-700 font-bold bg-green-50 px-1 rounded' : '' }} line-clamp-1">{{ $soal->pilihan_d }}</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase">
                                    Opsi {{ $soal->jawaban_benar }}
                                </span>
                            </td>
                            <td class="py-4 no-print">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('soal.edit', $soal->id) }}" class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
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
                            <td colspan="6" class="py-8 text-center text-gray-400">Tidak ada data soal ditemukan. Silakan tambahkan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $soals->links() }}
        </div>
    </div>
</div>

@endsection
