@extends('layouts.app')
@section('title', auth()->user()->role === 'admin' ? 'Monitoring Asesmen' : 'Asesmen Saya')
@section('page-title', auth()->user()->role === 'admin' ? 'Monitoring Asesmen' : 'Asesmen Saya')

@section('content')

@if(auth()->user()->role === 'admin')
{{-- ========== TAMPILAN ADMIN: TABLE ========== --}}

{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 no-print">
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <p class="text-xs text-blue-600 font-medium">Berlangsung</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalBerlangsung }}</p>
    </div>
    <div class="bg-green-50 border border-green-100 rounded-xl p-5">
        <p class="text-xs text-green-600 font-medium">Lulus</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalLulus }}</p>
    </div>
    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
        <p class="text-xs text-red-600 font-medium">Tidak Lulus</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTidakLulus }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6 no-print">
        <form method="GET" class="flex items-center gap-4">
            <div class="relative flex-1 max-w-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..."
                    class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            <select name="status" class="px-4 py-2 bg-gray-100 rounded-lg text-sm text-gray-600" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </form>
        <div class="relative group">
            <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                Export
            </button>
            <div class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                <button type="button" onclick="exportPDF()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</button>
                <button type="button" onclick="exportExcel('Laporan_Asesmen')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Peserta</th>
                    <th class="text-left pb-3 font-medium">Skema</th>
                    <th class="text-left pb-3 font-medium">Absensi</th>
                    <th class="text-left pb-3 font-medium">Quiz</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                    <th class="text-left pb-3 font-medium no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($asesmens as $index => $a)
                @php
                    $absensiHadir = $a->absensi->where('status', 'hadir')->count();
                    $absensiKonfirmasi = $a->absensi->where('dikonfirmasi_oleh', 'admin')->count();
                    $totalA = $a->absensi->count();
                    $statusColor = match($a->status) {
                        'berlangsung' => 'bg-blue-100 text-blue-700',
                        'lulus' => 'bg-green-100 text-green-700',
                        'tidak_lulus' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ $asesmens->firstItem() + $index }}</td>
                    <td class="py-3">
                        <p class="font-medium text-gray-800">{{ $a->pendaftaran->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $a->pendaftaran->user->email ?? '-' }}</p>
                    </td>
                    <td class="py-3 text-gray-600">{{ $a->pendaftaran->skema->nama ?? '-' }}</td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalA > 0 ? ($absensiKonfirmasi / $totalA) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $absensiKonfirmasi }}/{{ $totalA }}</span>
                        </div>
                    </td>
                    <td class="py-3">
                        @if($a->nilai_quiz !== null)
                            <span class="font-bold {{ $a->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $a->nilai_quiz }}%</span>
                        @else
                            <span class="text-gray-400 text-xs">Belum</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                        </span>
                    </td>
                    <td class="py-3 no-print">
                        <a href="{{ route('asesmen.show', $a->id) }}" class="px-3 py-1.5 bg-[#1e3a6e] text-white text-xs rounded-lg hover:bg-[#16305c] transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-gray-400">Belum ada data asesmen</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 no-print">{{ $asesmens->links() }}</div>
</div>

@else
{{-- ========== TAMPILAN USER: CARDS ========== --}}

{{-- Stats User --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <p class="text-xs text-blue-600 font-medium">Berlangsung</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalBerlangsung }}</p>
    </div>
    <div class="bg-green-50 border border-green-100 rounded-xl p-5">
        <p class="text-xs text-green-600 font-medium">Lulus</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalLulus }}</p>
    </div>
    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
        <p class="text-xs text-red-600 font-medium">Tidak Lulus</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTidakLulus }}</p>
    </div>
</div>

@forelse($asesmens as $asesmen)
@php
    $totalAbsensi = $asesmen->absensi->count();
    $absensiHadir = $asesmen->absensi->where('status', 'hadir')->count();
    $absensiKonfirmasi = $asesmen->absensi->where('status', 'hadir')->where('dikonfirmasi_oleh', 'admin')->count();
    $progressAbsensi = $totalAbsensi > 0 ? ($absensiHadir / $totalAbsensi) * 100 : 0;
    $statusColor = match($asesmen->status) {
        'berlangsung' => 'bg-blue-100 text-blue-700',
        'lulus' => 'bg-green-100 text-green-700',
        'tidak_lulus' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-600',
    };
@endphp
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <div class="flex items-start justify-between mb-5">
        <div>
            <h3 class="font-bold text-gray-900 text-lg">{{ $asesmen->pendaftaran->skema->nama ?? '-' }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $asesmen->pendaftaran->skema->kategori ?? '-' }} • Mulai {{ $asesmen->created_at->format('d M Y') }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
            {{ ucfirst(str_replace('_', ' ', $asesmen->status)) }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-xs text-blue-600 font-medium mb-1">Absensi</p>
            <p class="text-xl font-bold text-gray-900">{{ $absensiHadir }}/{{ $totalAbsensi }}</p>
            <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressAbsensi }}%"></div>
            </div>
        </div>
        <div class="bg-purple-50 rounded-xl p-4">
            <p class="text-xs text-purple-600 font-medium mb-1">Dikonfirmasi Admin</p>
            <p class="text-xl font-bold text-gray-900">{{ $absensiKonfirmasi }}/{{ $totalAbsensi }}</p>
            <div class="w-full bg-purple-200 rounded-full h-2 mt-2">
                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $totalAbsensi > 0 ? ($absensiKonfirmasi / $totalAbsensi) * 100 : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-green-50 rounded-xl p-4">
            <p class="text-xs text-green-600 font-medium mb-1">Quiz Final</p>
            @if($asesmen->nilai_quiz !== null)
                <p class="text-xl font-bold text-gray-900">{{ $asesmen->nilai_quiz }}%</p>
                <p class="text-xs mt-1 {{ $asesmen->nilai_quiz >= 60 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $asesmen->nilai_quiz >= 60 ? '✅ Lulus' : '❌ Tidak Lulus' }}
                </p>
            @else
                <p class="text-xl font-bold text-gray-400">Belum</p>
                <p class="text-xs text-gray-400 mt-1">Selesaikan absensi dulu</p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('asesmen.show', $asesmen->id) }}" class="px-5 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            Lihat Detail & Absensi
        </a>
        @if($asesmen->status === 'lulus' && $asesmen->no_sertifikat)
        <a href="{{ route('asesmen.sertifikat', $asesmen->id) }}" class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
            Lihat Sertifikat
        </a>
        @endif
    </div>
</div>
@empty
<div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
    <p class="text-gray-400 font-medium">Belum ada asesmen</p>
    <p class="text-sm text-gray-400 mt-1">Daftar dan bayar skema sertifikasi terlebih dahulu</p>
    <a href="{{ route('skema.index') }}" class="inline-block mt-4 px-5 py-2 bg-[#1e3a6e] text-white text-sm rounded-lg hover:bg-[#16305c] transition">Lihat Skema</a>
</div>
@endforelse

@endif

@endsection
