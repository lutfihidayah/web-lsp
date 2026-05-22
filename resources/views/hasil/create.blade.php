@extends('layouts.app')

@section('title', 'Tambah Hasil Sertifikasi')
@section('page-title', 'Tambah Hasil Sertifikasi')

@section('content')

{{-- Info Banner --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-5 flex items-start gap-3">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2" class="flex-shrink-0 mt-0.5">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <div>
        <p class="text-sm font-semibold text-blue-800">Alur Input Hasil Sertifikasi</p>
        <p class="text-xs text-blue-600 mt-1">
            Pilih peserta yang sudah terdaftar via pembayaran → pilih jadwal asesmen → isi nilai & hasil.
            Jika <strong>Kompeten</strong>, user bisa langsung download sertifikat dari halaman mereka.
        </p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Tambah Hasil Sertifikasi</h2>
        <p class="text-sm text-gray-400 mt-1">Isi formulir berikut untuk menambahkan hasil asesmen</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('hasil.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Peserta --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Peserta <span class="text-red-500">*</span></label>
            <select name="peserta_id" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Peserta --</option>
                @foreach($peserta as $p)
                <option value="{{ $p->id }}" {{ old('peserta_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }} — {{ $p->skema->nama ?? '-' }} ({{ $p->email }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- Jadwal --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jadwal Asesmen <span class="text-red-500">*</span></label>
            <select name="jadwal_id" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Jadwal --</option>
                @foreach($jadwals as $j)
                <option value="{{ $j->id }}" {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                    {{ $j->skema->nama ?? '-' }} — {{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }} | {{ $j->asesor }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Asesor --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Asesor <span class="text-red-500">*</span></label>
            <input type="text" name="asesor" value="{{ old('asesor') }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Nama asesor">
        </div>

        {{-- Nilai & Hasil --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai (0-100)</label>
                <input type="number" name="nilai" value="{{ old('nilai') }}" min="0" max="100"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Misal: 85">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hasil <span class="text-red-500">*</span></label>
                <select name="hasil" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700"
                    onchange="toggleSertifikat(this.value)">
                    @foreach(['Dalam Proses','Kompeten','Belum Kompeten'] as $h)
                    <option value="{{ $h }}" {{ old('hasil') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- No Sertifikat (hanya muncul jika Kompeten) --}}
        <div id="sertifikat_section" style="{{ old('hasil', 'Dalam Proses') === 'Kompeten' ? '' : 'display:none' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">No Sertifikat</label>
            <div class="flex gap-2">
                <input type="text" name="no_sertifikat" id="no_sertifikat" value="{{ old('no_sertifikat') }}"
                    class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Contoh: LSP-202605-1234">
                <button type="button" onclick="generateNomor()"
                    class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition whitespace-nowrap">
                    ⚡ Auto Generate
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-1">Nomor unik yang akan tampil di sertifikat user</p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Simpan Hasil
            </button>
            <a href="{{ route('hasil.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function toggleSertifikat(val) {
    document.getElementById('sertifikat_section').style.display = (val === 'Kompeten') ? 'block' : 'none';
}
function generateNomor() {
    const now = new Date();
    const year = now.getFullYear();
    const bulan = String(now.getMonth() + 1).padStart(2, '0');
    const rand = String(Math.floor(Math.random() * 9000) + 1000);
    document.getElementById('no_sertifikat').value = `LSP-${year}${bulan}-${rand}`;
}
</script>

@endsection
