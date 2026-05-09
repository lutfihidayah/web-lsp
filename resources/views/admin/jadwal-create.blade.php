@extends('admin.layout')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Tambah Jadwal Asesmen</h2>
        <p class="text-sm text-gray-400 mt-1">Isi formulir berikut untuk menambahkan jadwal baru</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Skema Sertifikasi <span class="text-red-500">*</span></label>
            <select name="skema_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Skema --</option>
                @foreach($skemas as $skema)
                <option value="{{ $skema->id }}" {{ old('skema_id') == $skema->id ? 'selected' : '' }}>{{ $skema->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu <span class="text-red-500">*</span></label>
                <input type="text" name="waktu" value="{{ old('waktu') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Contoh: 08.00 - 16.00">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Contoh: Ruang A101">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Asesor <span class="text-red-500">*</span></label>
                <input type="text" name="asesor" value="{{ old('asesor') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Nama asesor">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kuota <span class="text-red-500">*</span></label>
                <input type="number" name="kuota" value="{{ old('kuota', 30) }}" required min="1"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                @foreach(['Terjadwal','Berlangsung','Selesai','Dibatalkan'] as $s)
                <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Simpan Jadwal
            </button>
            <a href="{{ route('admin.jadwal') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
