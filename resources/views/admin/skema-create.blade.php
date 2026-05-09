@extends('admin.layout')

@section('title', 'Tambah Skema')
@section('page-title', 'Tambah Skema')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Tambah Skema Sertifikasi</h2>
        <p class="text-sm text-gray-400 mt-1">Isi formulir berikut untuk menambahkan skema baru</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.skema.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Skema <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Contoh: Junior Web Developer">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Kategori --</option>
                @foreach(['Teknologi Informasi','Pemasaran Digital','Administrasi','Desain'] as $kat)
                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Durasi <span class="text-red-500">*</span></label>
                <input type="text" name="durasi" value="{{ old('durasi') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Contoh: 2-3 Hari">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Kompetensi <span class="text-red-500">*</span></label>
                <input type="number" name="unit_kompetensi" value="{{ old('unit_kompetensi') }}" required min="1"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Jumlah unit">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
            <textarea name="deskripsi" rows="4"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Deskripsi singkat skema sertifikasi...">{{ old('deskripsi') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Biaya Sertifikasi (Rp) <span class="text-red-500">*</span></label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                <input type="number" name="harga" value="{{ old('harga', 1500000) }}" required min="0"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="1500000">
            </div>
            <p class="text-xs text-gray-400 mt-1">Contoh: 1500000 (tanpa titik atau koma)</p>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Simpan Skema
            </button>
            <a href="{{ route('admin.skema') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
