@extends('user.layout')
@section('title', 'Daftar Skema')
@section('page-title', 'Daftar Skema')

@section('content')

{{-- HEADER --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Daftar Skema Sertifikasi</h2>
    <p class="text-sm text-gray-500 mt-1">Pilih skema sertifikasi yang sesuai dengan kebutuhan Anda</p>
</div>

{{-- SEARCH & FILTER --}}
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

{{-- GRID SKEMA --}}
@if($skemas->isEmpty())
    <div class="bg-white rounded-xl border border-gray-100 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
        </svg>
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

            {{-- Banner --}}
            <div class="h-28 bg-gradient-to-br {{ $kategoriColor['grad'] }} flex items-center justify-center">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z"/>
                </svg>
            </div>

            {{-- Content --}}
            <div class="p-5">
                {{-- Badge kategori & status --}}
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $kategoriColor['bg'] }} {{ $kategoriColor['text'] }}">
                        {{ $skema->kategori }}
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">
                        Aktif
                    </span>
                </div>

                {{-- Nama --}}
                <h4 class="font-bold text-gray-900 text-base mb-1">{{ $skema->nama }}</h4>

                {{-- Deskripsi --}}
                <p class="text-xs text-gray-500 mb-4 line-clamp-2">
                    {{ $skema->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                </p>

                {{-- Info --}}
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <div class="flex items-center gap-1">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span>{{ $skema->durasi }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        <span>{{ $skema->peserta_count }} Peserta</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <span>{{ $skema->unit_kompetensi }} Unit</span>
                    </div>
                </div>

                {{-- Button --}}
                <a href="{{ route('user.skema.show', $skema->id) }}"
                    class="block w-full text-center border-2 border-[#1e3a6e] text-[#1e3a6e] text-sm font-bold py-2 rounded-lg hover:bg-[#1e3a6e] hover:text-white transition">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Search & Filter Script --}}
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
            const matchSearch = nama.includes(search);
            const matchKategori = kategori === '' || kat === kategori;
            card.style.display = (matchSearch && matchKategori) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);
    filterKategori.addEventListener('change', filterCards);
</script>

@endsection