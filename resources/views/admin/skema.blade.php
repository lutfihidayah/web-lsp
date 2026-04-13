@extends('admin.layout')

@section('title', 'Skema Sertifikasi')
@section('page-title', 'Skema Sertifikasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Data Skema Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total 30 skema aktif</p>
        </div>
        <button class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Skema
        </button>
    </div>

    {{-- Filter & Search --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="Cari skema..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Kategori</option>
            <option>Teknologi Informasi</option>
            <option>Pemasaran Digital</option>
            <option>Administrasi</option>
            <option>Desain</option>
        </select>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Tidak Aktif</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Nama Skema ↕</th>
                    <th class="text-left pb-3 font-medium">Kategori ↕</th>
                    <th class="text-left pb-3 font-medium">Durasi ↕</th>
                    <th class="text-left pb-3 font-medium">Unit Kompetensi ↕</th>
                    <th class="text-left pb-3 font-medium">Total Peserta ↕</th>
                    <th class="text-left pb-3 font-medium">Status ↕</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $skemas = [
                    ['01', 'Junior Web Developer', 'Teknologi Informasi', '2-3 Hari', '8 Unit', '134', 'Aktif', 'blue'],
                    ['02', 'Digital Marketing Specialist', 'Pemasaran Digital', '2 Hari', '6 Unit', '169', 'Aktif', 'green'],
                    ['03', 'Administrasi Perkantoran', 'Administrasi', '5 Hari', '10 Unit', '456', 'Aktif', 'yellow'],
                    ['04', 'Network Administrator', 'Teknologi Informasi', '3 Hari', '12 Unit', '161', 'Aktif', 'blue'],
                    ['05', 'Graphic Designer', 'Desain', '2 Hari', '7 Unit', '298', 'Aktif', 'red'],
                    ['06', 'Data Analyst', 'Teknologi Informasi', '3 Hari', '10 Unit', '145', 'Aktif', 'blue'],
                    ['07', 'UI/UX Designer', 'Desain', '3 Hari', '9 Unit', '112', 'Aktif', 'red'],
                    ['08', 'Cyber Security', 'Teknologi Informasi', '4 Hari', '14 Unit', '89', 'Tidak Aktif', 'gray'],
                    ['09', 'Software Engineer', 'Teknologi Informasi', '4 Hari', '12 Unit', '187', 'Aktif', 'blue'],
                    ['10', 'Administrasi Keuangan', 'Administrasi', '3 Hari', '8 Unit', '203', 'Aktif', 'yellow'],
                ];
                $colors = [
                    'blue'   => 'bg-blue-100 text-blue-700',
                    'green'  => 'bg-green-100 text-green-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'red'    => 'bg-red-100 text-red-700',
                    'gray'   => 'bg-gray-100 text-gray-600',
                ];
                $kategoriColors = [
                    'Teknologi Informasi' => 'bg-blue-50 text-blue-700',
                    'Pemasaran Digital'   => 'bg-green-50 text-green-700',
                    'Administrasi'        => 'bg-yellow-50 text-yellow-700',
                    'Desain'              => 'bg-red-50 text-red-700',
                ];
                @endphp

                @foreach($skemas as $s)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $s[0] }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $s[1] }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $kategoriColors[$s[2]] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $s[2] }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500">{{ $s[3] }}</td>
                    <td class="py-3 text-gray-500">{{ $s[4] }}</td>
                    <td class="py-3 text-gray-500">{{ $s[5] }} peserta</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$s[7]] }}">
                            {{ $s[6] }}
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
        <p class="text-sm text-gray-400">Menampilkan 1-10 dari 30 skema</p>
        <div class="flex items-center gap-1">
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">←</button>
            <button class="px-3 py-1.5 text-sm bg-[#1e3a6e] text-white rounded-lg">1</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">2</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">3</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">→</button>
        </div>
    </div>

</div>

@endsection