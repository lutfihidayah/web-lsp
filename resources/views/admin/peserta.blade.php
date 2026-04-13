@extends('admin.layout')

@section('title', 'Daftar Peserta')
@section('page-title', 'Daftar Peserta')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Data Peserta Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total 1.083 peserta terdaftar</p>
        </div>
        <button class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Peserta
        </button>
    </div>

    {{-- Filter & Search --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="Cari nama peserta..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Status</option>
            <option>Kompeten</option>
            <option>Belum Kompeten</option>
            <option>Dalam Proses</option>
            <option>Verifikasi</option>
            <option>Asesmen</option>
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
                    <th class="text-left pb-3 font-medium">ID ↕</th>
                    <th class="text-left pb-3 font-medium">Nama Peserta ↕</th>
                    <th class="text-left pb-3 font-medium">Email ↕</th>
                    <th class="text-left pb-3 font-medium">Tanggal Daftar ↕</th>
                    <th class="text-left pb-3 font-medium">Skema ↕</th>
                    <th class="text-left pb-3 font-medium">Status ↕</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $peserta = [
                    ['01', 'Lutfi Hidayah', 'lutfi@gmail.com', '06 Jun, 2025', 'Junior Developer', 'Verifikasi', 'yellow'],
                    ['02', 'Sofa Azzahra', 'sofa@gmail.com', '04 Jun, 2025', 'Network Administrator', 'Asesmen', 'blue'],
                    ['03', 'Dimas Mardiana', 'dimas@gmail.com', '03 Jun, 2025', 'Designer UI/UX', 'Belum Kompeten', 'red'],
                    ['04', "Mas'ud", 'masud@gmail.com', '02 Jun, 2025', 'Data Entry Operator', 'Kompeten', 'green'],
                    ['05', 'Rina Oktavia', 'rina@gmail.com', '01 Jun, 2025', 'Digital Marketing', 'Dalam Proses', 'yellow'],
                    ['06', 'Budi Santoso', 'budi@gmail.com', '30 Mei, 2025', 'Data Analyst', 'Kompeten', 'green'],
                    ['07', 'Anisa Rahmawati', 'anisa@gmail.com', '28 Mei, 2025', 'Junior Developer', 'Verifikasi', 'yellow'],
                    ['08', 'Hendra Wijaya', 'hendra@gmail.com', '27 Mei, 2025', 'Graphic Designer', 'Asesmen', 'blue'],
                ];
                $colors = [
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'blue'   => 'bg-blue-100 text-blue-700',
                    'red'    => 'bg-red-100 text-red-700',
                    'green'  => 'bg-green-100 text-green-700',
                ];
                @endphp

                @foreach($peserta as $p)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $p[0] }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $p[1] }}</td>
                    <td class="py-3 text-gray-500">{{ $p[2] }}</td>
                    <td class="py-3 text-gray-500">{{ $p[3] }}</td>
                    <td class="py-3 text-gray-500">{{ $p[4] }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$p[6]] }}">
                            {{ $p[5] }}
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
        <p class="text-sm text-gray-400">Menampilkan 1-8 dari 1.083 peserta</p>
        <div class="flex items-center gap-1">
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">←</button>
            <button class="px-3 py-1.5 text-sm bg-[#1e3a6e] text-white rounded-lg">1</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">2</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">3</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">...</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">→</button>
        </div>
    </div>

</div>

@endsection