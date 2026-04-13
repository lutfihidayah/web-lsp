@extends('admin.layout')

@section('title', 'Jadwal Asesmen')
@section('page-title', 'Jadwal Asesmen')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Jadwal Asesmen</h2>
            <p class="text-sm text-gray-400">Total 10 jadwal bulan ini</p>
        </div>
        <button class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Jadwal
        </button>
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input type="text" placeholder="Cari jadwal..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>
        <select class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
            <option>Semua Status</option>
            <option>Terjadwal</option>
            <option>Berlangsung</option>
            <option>Selesai</option>
            <option>Dibatalkan</option>
        </select>
        <input type="month" class="px-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Skema Sertifikasi ↕</th>
                    <th class="text-left pb-3 font-medium">Tanggal ↕</th>
                    <th class="text-left pb-3 font-medium">Waktu ↕</th>
                    <th class="text-left pb-3 font-medium">Lokasi ↕</th>
                    <th class="text-left pb-3 font-medium">Asesor ↕</th>
                    <th class="text-left pb-3 font-medium">Peserta ↕</th>
                    <th class="text-left pb-3 font-medium">Status ↕</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $jadwals = [
                    ['01', 'Junior Web Developer', '10 Jun, 2025', '08.00 - 16.00', 'Ruang A101', 'Budi Santoso', '25', 'Selesai', 'green'],
                    ['02', 'Digital Marketing', '12 Jun, 2025', '09.00 - 15.00', 'Ruang B202', 'Rina Oktavia', '20', 'Selesai', 'green'],
                    ['03', 'Network Administrator', '15 Jun, 2025', '08.00 - 17.00', 'Lab Jaringan', 'Hendra Wijaya', '18', 'Berlangsung', 'blue'],
                    ['04', 'Administrasi Perkantoran', '18 Jun, 2025', '08.00 - 14.00', 'Ruang C303', 'Anisa Rahmawati', '30', 'Terjadwal', 'yellow'],
                    ['05', 'Graphic Designer', '20 Jun, 2025', '09.00 - 16.00', 'Lab Desain', 'Sofa Azzahra', '22', 'Terjadwal', 'yellow'],
                    ['06', 'Data Analyst', '22 Jun, 2025', '08.00 - 15.00', 'Ruang A102', 'Dimas Mardiana', '15', 'Terjadwal', 'yellow'],
                    ['07', 'UI/UX Designer', '25 Jun, 2025', '09.00 - 16.00', 'Lab Desain', 'Lutfi Hidayah', '19', 'Terjadwal', 'yellow'],
                    ['08', 'Software Engineer', '27 Jun, 2025', '08.00 - 17.00', 'Lab Komputer', 'Budi Santoso', '28', 'Terjadwal', 'yellow'],
                    ['09', 'Cyber Security', '28 Jun, 2025', '08.00 - 16.00', 'Lab Jaringan', 'Hendra Wijaya', '12', 'Dibatalkan', 'red'],
                    ['10', 'Data Analyst', '30 Jun, 2025', '09.00 - 15.00', 'Ruang B201', 'Rina Oktavia', '17', 'Terjadwal', 'yellow'],
                ];
                $colors = [
                    'green'  => 'bg-green-100 text-green-700',
                    'blue'   => 'bg-blue-100 text-blue-700',
                    'yellow' => 'bg-yellow-100 text-yellow-700',
                    'red'    => 'bg-red-100 text-red-700',
                ];
                @endphp

                @foreach($jadwals as $j)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $j[0] }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $j[1] }}</td>
                    <td class="py-3 text-gray-500">{{ $j[2] }}</td>
                    <td class="py-3 text-gray-500">{{ $j[3] }}</td>
                    <td class="py-3 text-gray-500">{{ $j[4] }}</td>
                    <td class="py-3 text-gray-500">{{ $j[5] }}</td>
                    <td class="py-3 text-gray-500">{{ $j[6] }} orang</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$j[8]] }}">
                            {{ $j[7] }}
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
        <p class="text-sm text-gray-400">Menampilkan 1-10 dari 10 jadwal</p>
        <div class="flex items-center gap-1">
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">←</button>
            <button class="px-3 py-1.5 text-sm bg-[#1e3a6e] text-white rounded-lg">1</button>
            <button class="px-3 py-1.5 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500">→</button>
        </div>
    </div>

</div>

@endsection