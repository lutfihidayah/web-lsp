@extends('admin.layout')
@section('title', 'Monitoring Asesmen')
@section('page-title', 'Monitoring Asesmen')

@section('content')

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6">{{ session('success') }}</div>
@endif

{{-- Stats --}}
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

{{-- Filter --}}
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <form method="GET" class="flex items-center gap-4 mb-6">
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

    {{-- Table --}}
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
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($asesmens as $index => $a)
                @php
                    $absensiHadir = $a->absensi->where('status', 'hadir')->count();
                    $absensiKonfirmasi = $a->absensi->where('dikonfirmasi_oleh', 'admin')->count();
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
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($absensiKonfirmasi / 10) * 100 }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $absensiKonfirmasi }}/10</span>
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
                    <td class="py-3">
                        <a href="{{ route('admin.asesmen.show', $a->id) }}" class="px-3 py-1.5 bg-[#1e3a6e] text-white text-xs rounded-lg hover:bg-[#16305c] transition">
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

    <div class="mt-4">{{ $asesmens->links() }}</div>
</div>

@endsection
