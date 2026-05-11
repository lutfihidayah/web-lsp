@extends('admin.layout')

@section('title', 'Daftar Peserta')
@section('page-title', 'Daftar Peserta')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Data Peserta Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total {{ $peserta->count() }} peserta terdaftar</p>
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
                    <button type="button" onclick="exportExcel('Laporan_Peserta')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg flex items-center gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="17"/><line x1="16" y1="13" x2="8" y2="17"/></svg>
                        Export Excel
                    </button>
                </div>
            </div>
            <button onclick="openModal('createModal')"
                class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                + Tambah Peserta
            </button>
        </div>
    </div>
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
    {{ session('success') }}
</div>
@endif
    {{-- Filter & Search --}}
    <div class="flex items-center gap-4 mb-6 no-print">
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
                    <th class="text-left pb-3 font-medium no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
    @forelse($peserta as $p)
    <tr class="hover:bg-gray-50">
        <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
        <td class="py-3 font-medium text-gray-800">{{ $p->nama }}</td>
        <td class="py-3 text-gray-500">{{ $p->email }}</td>
        <td class="py-3 text-gray-500">{{ $p->created_at->format('d M, Y') }}</td>
        <td class="py-3 text-gray-500">{{ $p->skema->nama ?? '-' }}</td>
        <td class="py-3">
            @php
            $colors = ['Verifikasi'=>'bg-yellow-100 text-yellow-700','Asesmen'=>'bg-blue-100 text-blue-700','Kompeten'=>'bg-green-100 text-green-700','Belum Kompeten'=>'bg-red-100 text-red-700','Dalam Proses'=>'bg-yellow-100 text-yellow-700'];
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ $p->status }}
            </span>
        </td>
        <td class="py-3 no-print">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.peserta.edit', $p->id) }}" class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form action="{{ route('admin.peserta.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-red-500" title="Hapus">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="py-8 text-center text-gray-400">Belum ada data peserta</td>
    </tr>
    @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100 no-print">
        <p class="text-sm text-gray-400">Total {{ $peserta->count() }} peserta</p>
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

{{-- MODAL TAMBAH PESERTA --}}
<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Tambah Peserta Baru</h2>
                <p class="text-sm text-gray-400">Isi data peserta sertifikasi</p>
            </div>
            <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.peserta.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            placeholder="Masukan nama lengkap"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="Masukan email"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                            placeholder="Masukan no. telepon"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3"
                            placeholder="Masukan alamat lengkap"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Skema Sertifikasi <span class="text-red-500">*</span></label>
                        <select name="skema_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                            <option value="">-- Pilih Skema --</option>
                            @foreach($skemas as $skema)
                                <option value="{{ $skema->id }}" {{ old('skema_id') == $skema->id ? 'selected' : '' }}>
                                    {{ $skema->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                            <option value="">-- Pilih Status --</option>
                            <option value="Verifikasi" {{ old('status') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                            <option value="Asesmen" {{ old('status') == 'Asesmen' ? 'selected' : '' }}>Asesmen</option>
                            <option value="Dalam Proses" {{ old('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="Kompeten" {{ old('status') == 'Kompeten' ? 'selected' : '' }}>Kompeten</option>
                            <option value="Belum Kompeten" {{ old('status') == 'Belum Kompeten' ? 'selected' : '' }}>Belum Kompeten</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeModal('createModal')" class="px-6 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                        Simpan Peserta
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