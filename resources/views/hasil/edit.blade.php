@extends('layouts.app')

@section('title', 'Edit Hasil Asesmen')
@section('page-title', 'Edit Hasil Asesmen')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Edit Hasil Asesmen</h2>
        <p class="text-sm text-gray-400 mt-1">
            Peserta: <strong>{{ $asesmen->pendaftaran->user->name ?? '-' }}</strong>
            — Skema: <strong>{{ $asesmen->pendaftaran->skema->nama ?? '-' }}</strong>
        </p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('hasil.update', $asesmen->id) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        {{-- Status Asesmen --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Status Asesmen <span class="text-red-500">*</span>
            </label>
            <select name="status" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="berlangsung" {{ old('status', $asesmen->status) === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="lulus"       {{ old('status', $asesmen->status) === 'lulus'       ? 'selected' : '' }}>Lulus / Kompeten</option>
                <option value="tidak_lulus" {{ old('status', $asesmen->status) === 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus / Belum Kompeten</option>
            </select>
        </div>

        {{-- Nilai Quiz --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai Quiz (0–100)</label>
            <input type="number" name="nilai_quiz"
                value="{{ old('nilai_quiz', $asesmen->nilai_quiz) }}"
                min="0" max="100" step="0.01"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Isi jika ingin override nilai">
        </div>

        {{-- Nomor Sertifikat --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Nomor Sertifikat
                <span class="text-gray-400 font-normal">(otomatis dari sistem, isi jika override)</span>
            </label>
            <input type="text" name="no_sertifikat"
                value="{{ old('no_sertifikat', $asesmen->no_sertifikat) }}"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Contoh: LSP-202501-0001">
            @if($asesmen->sertifikat_dibuat_at)
            <p class="text-xs text-gray-400 mt-1">
                Sertifikat dibuat: {{ $asesmen->sertifikat_dibuat_at->format('d M Y H:i') }}
            </p>
            @endif
        </div>

        {{-- Info hanya baca --}}
        <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-500 space-y-1">
            <p>📋 <strong>ID Asesmen:</strong> #{{ $asesmen->id }}</p>
            <p>📅 <strong>Dibuat:</strong> {{ $asesmen->created_at->format('d M Y') }}</p>
            @if($asesmen->pendaftaran->jadwal)
            <p>🗓️ <strong>Jadwal:</strong> {{ \Carbon\Carbon::parse($asesmen->pendaftaran->jadwal->tanggal)->format('d M Y') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Perbarui Hasil
            </button>
            <a href="{{ route('hasil.index') }}"
                class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
