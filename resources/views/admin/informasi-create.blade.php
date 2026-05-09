@extends('admin.layout')

@section('title', 'Tambah Informasi')
@section('page-title', 'Tambah Informasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Tambah Informasi / Berita</h2>
        <p class="text-sm text-gray-400 mt-1">Isi formulir untuk menambahkan informasi baru</p>
    </div>

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

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Simpan Informasi
            </button>
            <a href="{{ route('admin.informasi') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
