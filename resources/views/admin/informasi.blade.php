@extends('admin.layout')

@section('title', 'Informasi')
@section('page-title', 'Informasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Manajemen Informasi & Berita</h2>
            <p class="text-sm text-gray-400">Total 12 artikel dipublikasikan</p>
        </div>
        <button class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Informasi
        </button>
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="Cari informasi..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Kategori</option>
            <option>Pengumuman</option>
            <option>Berita</option>
            <option>Tips</option>
            <option>Kerjasama</option>
        </select>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Status</option>
            <option>Dipublikasikan</option>
            <option>Draft</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Judul ↕</th>
                    <th class="text-left pb-3 font-medium">Kategori ↕</th>
                    <th class="text-left pb-3 font-medium">Penulis ↕</th>
                    <th class="text-left pb-3 font-medium">Tanggal ↕</th>
                    <th class="text-left pb-3 font-medium">Dilihat ↕</th>
                    <th class="text-left pb-3 font-medium">Status ↕</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $informasi = [
                    ['01', 'Pembukaan Pendaftaran Sertifikasi Batch Januari 2026', 'Pengumuman', 'Admin LSP', '5 Des, 2025', '1.2K', 'Dipublikasikan', 'green'],
                    ['02', 'Kerjasama dengan Industri untuk Peningkatan Kompetensi', 'Kerjasama', 'Admin LSP', '28 Nov, 2025', '876', 'Dipublikasikan', 'green'],
                    ['03', 'Tips Sukses Menghadapi Uji Kompetensi', 'Tips', 'Admin LSP', '10 Nov, 2025', '2.1K', 'Dipublikasikan', 'green'],
                    ['04', 'Peluncuran Skema Sertifikasi Baru 2025', 'Berita', 'Admin LSP', '1 Nov, 2025', '654', 'Dipublikasikan', 'green'],
                    ['05', 'Workshop Persiapan Uji Kompetensi Gratis', 'Pengumuman', 'Admin LSP', '20 Okt, 2025', '432', 'Dipublikasikan', 'green'],
                    ['06', 'Penghargaan LSP Terbaik Nasional 2025', 'Berita', 'Admin LSP', '15 Okt, 2025', '987', 'Dipublikasikan', 'green'],
                    ['07', 'Panduan Lengkap Upload Dokumen Persyaratan', 'Tips', 'Admin LSP', '10 Okt, 2025', '1.5K', 'Dipublikasikan', 'green'],
                    ['08', 'Rencana Pembukaan Batch Baru Februari 2026', 'Pengumuman', 'Admin LSP', '5 Okt, 2025', '-', 'Draft', 'yellow'],
                ];
                $colors = [
                    'green'  => 'bg-green-100 text-green-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                ];
                $kategoriColors = [
                    'Pengumuman' => 'bg-blue-50 text-blue-700',
                    'Berita'     => 'bg-purple-50 text-purple-700',
                    'Tips'       => 'bg-green-50 text-green-700',
                    'Kerjasama'  => 'bg-orange-50 text-orange-700',
                ];
                @endphp

                @foreach($informasi as $i)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $i[0] }}</td>
                    <td class="py-3 font-medium text-gray-800 max-w-xs">
                        <p class="truncate">{{ $i[1] }}</p>
                    </td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $kategoriColors[$i[2]] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $i[2] }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500">{{ $i[3] }}</td>
                    <td class="py-3 text-gray-500">{{ $i[4] }}</td>
                    <td class="py-3 text-gray-500">{{ $i[5] }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$i[7]] }}">
                            {{ $i[6] }}
                        </span>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <button class="p-1.5 hover:bg-blue-50 rounded-lg text-blue-600" title="Detail">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button class="p-1.5 hover:bg-red-50 rounded-lg text-red-500" title="Hapus">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
        <p class="text-sm text-gray-400">Menampilkan 1-8 dari 12 informasi</p>
        <div class="flex items-center gap-1">
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">←</button>
            <button class="px-3 py-1.5 text-sm bg-[#1e3a6e] text-white rounded-lg">1</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">2</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">→</button>
        </div>
    </div>

</div>

@endsection