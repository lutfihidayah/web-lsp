@extends('admin.layout')

@section('title', 'Edit Peserta')
@section('page-title', 'Edit Peserta')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Edit Data Peserta</h2>
        <p class="text-sm text-gray-400 mt-1">Perbarui data peserta: <span class="font-medium text-gray-600">{{ $peserta->nama }}</span></p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $peserta->nama) }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $peserta->email) }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">No Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon', $peserta->no_telepon) }}"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="08xxxxxxxxxx">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
            <textarea name="alamat" rows="3"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">{{ old('alamat', $peserta->alamat) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Skema Sertifikasi <span class="text-red-500">*</span></label>
            <select name="skema_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                @foreach($skemas as $skema)
                <option value="{{ $skema->id }}" {{ old('skema_id', $peserta->skema_id) == $skema->id ? 'selected' : '' }}>{{ $skema->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                @foreach(['Verifikasi','Asesmen','Kompeten','Belum Kompeten','Dalam Proses'] as $s)
                <option value="{{ $s }}" {{ old('status', $peserta->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Perbarui Peserta
            </button>
            <a href="{{ route('admin.peserta') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
