@extends('layouts.app')

@section('title', 'Skema Sertifikasi')
@section('page-title', 'Skema Sertifikasi')

@section('content')

@if(auth()->user()->role === 'admin')
{{-- ========== TAMPILAN ADMIN: TABLE + CRUD ========== --}}
<div class="bg-white rounded-xl border border-gray-200 p-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-bold text-gray-800 text-lg">Data Skema Sertifikasi</h2>
            <p class="text-sm text-gray-400">Total {{ $skemas->count() }} skema terdaftar</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 no-print w-full sm:w-auto mt-2 sm:mt-0">
            <div class="relative group">
                <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export
                </button>
                <div class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <button type="button" onclick="exportPDF()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">Export PDF</button>
                    <button type="button" onclick="exportExcel('Laporan_Skema')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">Export Excel</button>
                </div>
            </div>
            <a href="{{ route('skema.create') }}" class="px-4 py-2 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                + Tambah Skema
            </a>
        </div>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm min-w-[800px]">
            <thead>
                <tr class="border-b border-gray-100 text-gray-400 text-xs">
                    <th class="text-left pb-3 font-medium">No</th>
                    <th class="text-left pb-3 font-medium">Nama Skema</th>
                    <th class="text-left pb-3 font-medium">Kategori</th>
                    <th class="text-left pb-3 font-medium">Durasi</th>
                    <th class="text-left pb-3 font-medium">Unit Kompetensi</th>
                    <th class="text-left pb-3 font-medium">Total Peserta</th>
                    <th class="text-left pb-3 font-medium">Status</th>
                    <th class="text-left pb-3 font-medium no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $kategoriColors = [
                    'Teknologi Informasi' => 'bg-blue-50 text-blue-700',
                    'Pemasaran Digital'   => 'bg-green-50 text-green-700',
                    'Administrasi'        => 'bg-yellow-50 text-yellow-700',
                    'Desain'              => 'bg-red-50 text-red-700',
                ];
                @endphp

                @forelse($skemas as $s)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-gray-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 font-medium text-gray-800">{{ $s->nama }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $kategoriColors[$s->kategori] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $s->kategori }}
                        </span>
                    </td>
                    <td class="py-3 text-gray-500">{{ $s->durasi }}</td>
                    <td class="py-3 text-gray-500">{{ $s->unit_kompetensi }} Unit</td>
                    <td class="py-3 text-gray-500">{{ $s->peserta_count }} peserta</td>
                    <td class="py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $s->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $s->status }}
                        </span>
                    </td>
                    <td class="py-3 no-print">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('skema.edit', $s->id) }}" class="p-1.5 hover:bg-yellow-50 rounded-lg text-yellow-600" title="Edit">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form action="{{ route('skema.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus skema ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-red-50 rounded-lg text-red-500" title="Hapus">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-8 text-center text-gray-400">Belum ada data skema</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@else
{{-- ========== TAMPILAN USER: CARD GRID ========== --}}

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Daftar Skema Sertifikasi</h2>
    <p class="text-sm text-gray-500 mt-1">Pilih skema sertifikasi yang sesuai dengan kebutuhan Anda</p>
</div>

<div class="flex items-center gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <input type="text" id="searchInput" placeholder="Cari skema..."
            class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
    </div>
    <select id="filterKategori" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-600">
        <option value="">Semua Kategori</option>
        <option>Teknologi Informasi</option>
        <option>Pemasaran Digital</option>
        <option>Administrasi</option>
        <option>Desain</option>
    </select>
</div>

@if($skemas->isEmpty())
    <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
        <p class="text-gray-500 font-medium">Belum ada skema tersedia</p>
        <p class="text-gray-400 text-sm mt-1">Silakan cek kembali nanti</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="skemaGrid">
        @foreach($skemas as $skema)
        @php
            $kategoriColor = match($skema->kategori) {
                'Teknologi Informasi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'grad' => 'from-blue-500 to-blue-700'],
                'Pemasaran Digital'   => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'grad' => 'from-purple-500 to-pink-500'],
                'Administrasi'        => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'grad' => 'from-yellow-400 to-orange-400'],
                'Desain'              => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'grad' => 'from-red-400 to-pink-500'],
                default               => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'grad' => 'from-gray-400 to-gray-600'],
            };
        @endphp
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition skema-card"
             data-kategori="{{ $skema->kategori }}" data-nama="{{ strtolower($skema->nama) }}">
            <div class="h-28 bg-gradient-to-br {{ $kategoriColor['grad'] }} flex items-center justify-center">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
                </svg>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $kategoriColor['bg'] }} {{ $kategoriColor['text'] }}">
                        {{ $skema->kategori }}
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">Aktif</span>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-1">{{ $skema->nama }}</h4>
                <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $skema->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <span>{{ $skema->durasi }}</span>
                    <span>{{ $skema->peserta_count }} Peserta</span>
                    <span>{{ $skema->unit_kompetensi }} Unit</span>
                </div>
                <a href="{{ route('skema.show', $skema->id) }}"
                    class="block w-full text-center border-2 border-[#1e3a6e] text-[#1e3a6e] text-sm font-bold py-2 rounded-lg hover:bg-[#1e3a6e] hover:text-white transition">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const cards = document.querySelectorAll('.skema-card');

    function filterCards() {
        const search = searchInput.value.toLowerCase();
        const kategori = filterKategori.value.toLowerCase();
        cards.forEach(card => {
            const nama = card.dataset.nama;
            const kat = card.dataset.kategori.toLowerCase();
            card.style.display = (nama.includes(search) && (kategori === '' || kat === kategori)) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);
    filterKategori.addEventListener('change', filterCards);
</script>

@endif

@endsection
