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
        <div class="flex items-center gap-2 no-print">
            <div class="relative group">
                <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
                <div class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <button type="button" onclick="exportPDF()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Export PDF
                    </button>
                    <button type="button" onclick="exportExcel('Laporan_Informasi')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="17"/><line x1="16" y1="13" x2="8" y2="17"/></svg>
                        Export Excel
                    </button>
                </div>
            </div>
            <button onclick="openModal('createModal')" class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                + Tambah Informasi
            </button>
        </div>
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
                    <th class="text-left pb-3 font-medium no-print">Aksi</th>
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
                    <td class="py-3 no-print">
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

{{-- MODAL TAMBAH INFORMASI --}}
<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Tambah Informasi / Berita</h2>
                <p class="text-sm text-gray-400 mt-1">Isi formulir untuk menambahkan informasi baru</p>
            </div>
            <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.informasi.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="Judul informasi atau berita">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(['Pengumuman','Berita','Tips','Kerjasama'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', 'Admin LSP') }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Isi Konten <span class="text-red-500">*</span></label>
                    <textarea name="isi" rows="6" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="Tulis konten informasi di sini...">{{ old('isi') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Dipublikasikan" {{ old('status') == 'Dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('createModal')" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                        Simpan Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        openModal('createModal');
    });
</script>
@endif

@endsection