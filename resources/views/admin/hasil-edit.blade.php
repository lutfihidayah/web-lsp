@extends('admin.layout')

@section('title', 'Edit Hasil Sertifikasi')
@section('page-title', 'Edit Hasil Sertifikasi')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Edit Hasil Sertifikasi</h2>
        <p class="text-sm text-gray-400 mt-1">Perbarui data hasil asesmen</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.hasil.update', $h->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Peserta <span class="text-red-500">*</span></label>
            <select name="peserta_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                @foreach($peserta as $p)
                <option value="{{ $p->id }}" {{ old('peserta_id', $h->peserta_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }} ({{ $p->email }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jadwal Asesmen <span class="text-red-500">*</span></label>
            <select name="jadwal_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                @foreach($jadwals as $j)
                <option value="{{ $j->id }}" {{ old('jadwal_id', $h->jadwal_id) == $j->id ? 'selected' : '' }}>
                    {{ $j->skema->nama ?? '-' }} — {{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Asesor <span class="text-red-500">*</span></label>
            <input type="text" name="asesor" value="{{ old('asesor', $h->asesor) }}" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai (0-100)</label>
                <input type="number" name="nilai" value="{{ old('nilai', $h->nilai) }}" min="0" max="100"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hasil <span class="text-red-500">*</span></label>
                <select name="hasil" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                    @foreach(['Dalam Proses','Kompeten','Belum Kompeten'] as $hs)
                    <option value="{{ $hs }}" {{ old('hasil', $h->hasil) == $hs ? 'selected' : '' }}>{{ $hs }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">No Sertifikat</label>
            <input type="text" name="no_sertifikat" value="{{ old('no_sertifikat', $h->no_sertifikat) }}"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Perbarui Hasil
            </button>
            <a href="{{ route('admin.hasil') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
