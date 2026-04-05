@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#1e3a6e] text-white rounded-xl p-6">
        <div class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <p class="text-blue-200 text-sm">Total Peserta</p>
        <div class="flex items-end justify-between mt-1">
            <p class="text-3xl font-bold">1.083</p>
            <span class="bg-green-400 text-green-900 text-xs font-bold px-2 py-1 rounded-full">+4.9%</span>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Total Peserta Aktif</p>
        <div class="flex items-end justify-between mt-1">
            <p class="text-3xl font-bold text-gray-800">567</p>
            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">+167</span>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Skema Aktif</p>
        <div class="flex items-end justify-between mt-1">
            <p class="text-3xl font-bold text-gray-800">30</p>
            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">-4.9%</span>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Jadwal Bulan ini</p>
        <div class="flex items-end justify-between mt-1">
            <p class="text-3xl font-bold text-gray-800">10</p>
            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">+4.9%</span>
        </div>
    </div>
</div>

{{-- CHARTS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="md:col-span-2 bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800">Trend Pendaftaran Peserta</h3>
            <select class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none">
                <option>Weekly</option>
                <option>Monthly</option>
            </select>
        </div>
        <canvas id="trendChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <h3 class="font-bold text-gray-800 mb-4">Status Kompetensi</h3>
        <canvas id="statusChart" height="200"></canvas>
        <div class="space-y-2 mt-4">
            <div class="flex items-center gap-2 text-sm">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-gray-600">856 Kompeten</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <span class="text-gray-600">102 Belum</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <span class="text-gray-600">245 Dalam Proses</span>
            </div>
        </div>
    </div>
</div>

{{-- BOTTOM --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <h3 class="font-bold text-gray-800 mb-4">Berita Sertifikasi</h3>
        <div class="space-y-3">
            @foreach(['Sertifikasi BNSP Siap Kerja', 'Mampu Bersaing di Gelobal', 'Hasilkan Generasi Kompeten'] as $berita)
            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                <div class="w-10 h-10 bg-[#1e3a6e] rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">{{ $berita }}</p>
                    <p class="text-xs text-gray-400">Lorem ipsum dolor sit amet, con...</p>
                </div>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800">Daftar Peserta Terbaru</h3>
            <a href="{{ route('admin.peserta') }}" class="text-xs text-[#1e3a6e] font-medium">See All →</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-400 text-xs border-b border-gray-100">
                    <th class="text-left pb-3">ID</th>
                    <th class="text-left pb-3">Nama</th>
                    <th class="text-left pb-3">Skema</th>
                    <th class="text-left pb-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $peserta = [
                    ['01', 'Lutfi Hidayah', 'Junior Developer', 'Verifikasi', 'yellow'],
                    ['02', 'Sofa Azzahra', 'Network Admin', 'Asesmen', 'blue'],
                    ['03', 'Dimas Mardiana', 'Designer UI/UX', 'Belum Kompeten', 'red'],
                    ['04', "Mas'ud", 'Data Entry', 'Kompeten', 'green'],
                ];
                $colors = ['yellow'=>'bg-yellow-100 text-yellow-700','blue'=>'bg-blue-100 text-blue-700','red'=>'bg-red-100 text-red-700','green'=>'bg-green-100 text-green-700'];
                @endphp
                @foreach($peserta as $p)
                <tr>
                    <td class="py-3 text-gray-400">{{ $p[0] }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $p[1] }}</td>
                    <td class="py-3 text-gray-500">{{ $p[2] }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$p[3]] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $p[3] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: ['Jun 8','Jun 10','Jun 12','Jun 14','Jun 16','Jun 18','Jun 20','Jun 22','Jun 24','Jun 28'],
        datasets: [{
            data: [30,60,45,80,100,167,130,110,140,120],
            borderColor: '#1e3a6e',
            backgroundColor: 'rgba(30,58,110,0.05)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#1e3a6e',
            pointRadius: 3,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [856, 102, 245],
            backgroundColor: ['#22c55e','#ef4444','#facc15'],
            borderWidth: 0,
        }]
    },
    options: { plugins: { legend: { display: false } }, cutout: '70%' }
});
</script>

@endsection