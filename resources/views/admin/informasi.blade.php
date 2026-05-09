@extends('admin.layout')

@section('title', 'Informasi')
@section('page-title', 'Informasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Manajemen Informasi & Berita</h2>
            <p class="text-sm text-gray-400">Total {{ $informasi->count() }} artikel</p>
        </div>
        <a href="{{ route('admin.informasi.create') }}" class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
            + Tambah Informasi
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Judul</th>
                    <th class="text-left pb-3 font-medium">Kategori</th>
                    <th class="text-left pb-3 font-medium">Penulis</th>
                    <th class="text-left pb-3 font-medium">Tanggal</th>
                    <th class="text-left pb-3 font-medium">Dilihat</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                    <th class="text-left pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $statusColors = [
                    'Dipublikasikan' => 'bg-green-100 text-green-700',
                    'Draft'          => 'bg-yellow-100 text-yellow-700',
                ];
                $kategoriColors = [
                    'Pengumuman' => 'bg-blue-50 text-blue-700',
                    'Berita'     => 'bg-purple-50 text-purple-700',
                    'Tips'       => 'bg-green-50 text-green-700',
                    'Kerjasama'  => 'bg-orange-50 text-orange-700',
                ];
                @endphp

                @forelse($informasi as $i)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 font-medium text-gray-800 max-w-xs">
                        <p class="truncate">{{ $i->judul }}</p>
                    </td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $kategoriColors[$i->kategori] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $i->kategori }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500">{{ $i->penulis }}</td>
                    <td class="py-3 text-gray-500">{{ $i->created_at->format('d M, Y') }}</td>
                    <td class="py-3 text-gray-500">{{ number_format($i->dilihat) }}</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$i->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $i->status }}
                        </span>
                    </td>
                    <td class="py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.informasi.edit', $i->id) }}" class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.informasi.destroy', $i->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
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
                    <td colspan="8" class="py-8 text-center text-gray-400">Belum ada informasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection