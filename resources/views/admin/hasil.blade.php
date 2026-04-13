@extends('admin.layout')

@section('title', 'Hasil Sertifikasi')
@section('page-title', 'Hasil Sertifikasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Hasil Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total 1.083 hasil sertifikasi</p>
        </div>
        <button class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Hasil
        </button>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
            <p class="text-sm text-green-600 font-medium">Kompeten</p>
            <p class="text-3xl font-bold text-green-700 mt-1">856</p>
        </div>
        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
            <p class="text-sm text-red-600 font-medium">Belum Kompeten</p>
            <p class="text-3xl font-bold text-red-700 mt-1">102</p>
        </div>
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
            <p class="text-sm text-yellow-600 font-medium">Dalam Proses</p>
            <p class="text-3xl font-bold text-yellow-700 mt-1">245</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="Cari nama peserta..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Hasil</option>
            <option>Kompeten</option>
            <option>Belum Kompeten</option>
            <option>Dalam Proses</option>
        </select>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Skema</option>
            <option>Junior Web Developer</option>
            <option>Network Administrator</option>
            <option>Digital Marketing</option>
            <option>Data Analyst</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Nama Peserta ↕</th>
                    <th class="text-left pb-3 font-medium">Skema ↕</th>
                    <th class="text-left pb-3 font-medium">Tanggal Asesmen ↕</th>
                    <th class="text-left pb-3 font-medium">Asesor ↕</th>
                    <th class="text-left pb-3 font-medium">Nilai ↕</th>
                    <th class="text-left pb-3 font-medium">Hasil ↕</th>
                    <th class="text-left pb-3 font-medium">No Sertifikat ↕</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $hasil = [
                    ['01', 'Lutfi Hidayah', 'Junior Web Developer', '10 Jun, 2025', 'Budi Santoso', '85', 'Kompeten', 'LSP-001-2025', 'green'],
                    ['02', 'Sofa Azzahra', 'Network Administrator', '10 Jun, 2025', 'Hendra Wijaya', '78', 'Kompeten', 'LSP-002-2025', 'green'],
                    ['03', 'Dimas Mardiana', 'Designer UI/UX', '12 Jun, 2025', 'Anisa Rahmawati', '55', 'Belum Kompeten', '-', 'red'],
                    ['04', "Mas'ud", 'Data Entry Operator', '12 Jun, 2025', 'Rina Oktavia', '90', 'Kompeten', 'LSP-004-2025', 'green'],
                    ['05', 'Rina Oktavia', 'Digital Marketing', '15 Jun, 2025', 'Budi Santoso', '-', 'Dalam Proses', '-', 'yellow'],
                    ['06', 'Budi Santoso', 'Data Analyst', '15 Jun, 2025', 'Lutfi Hidayah', '88', 'Kompeten', 'LSP-006-2025', 'green'],
                    ['07', 'Anisa Rahmawati', 'Junior Web Developer', '18 Jun, 2025', 'Sofa Azzahra', '-', 'Dalam Proses', '-', 'yellow'],
                    ['08', 'Hendra Wijaya', 'Graphic Designer', '18 Jun, 2025', 'Dimas Mardiana', '60', 'Belum Kompeten', '-', 'red'],
                ];
                $colors = [
                    'green'  => 'bg-green-100 text-green-700',
                    'red'    => 'bg-red-100 text-red-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                ];
                @endphp

                @foreach($hasil as $h)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $h[0] }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $h[1] }}</td>
                    <td class="py-3 text-gray-500">{{ $h[2] }}</td>
                    <td class="py-3 text-gray-500">{{ $h[3] }}</td>
                    <td class="py-3 text-gray-500">{{ $h[4] }}</td>
                    <td class="py-3 text-gray-500">{{ $h[5] }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$h[8]] }}">
                            {{ $h[6] }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500 font-mono text-xs">{{ $h[7] }}</td>
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
                            <button class="p-1.5 hover:bg-green-50 rounded-lg text-green-600" title="Download Sertifikat">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
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
        <p class="text-sm text-gray-400">Menampilkan 1-8 dari 1.083 hasil</p>
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