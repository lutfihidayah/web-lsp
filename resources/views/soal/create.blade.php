@extends('layouts.app')

@section('title', 'Tambah Soal')
@section('page-title', 'Tambah Soal')

@section('content')

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
    <div class="mb-6">
        <h2 class="font-bold text-gray-800 text-lg">Tambah Pertanyaan Baru</h2>
        <p class="text-sm text-gray-400 mt-1">Tambahkan pertanyaan baru untuk ujian skema sertifikasi</p>
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

    <form action="{{ route('soal.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Skema Sertifikasi <span class="text-red-500">*</span></label>
            <select name="skema_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Skema --</option>
                @foreach($skemas as $sk)
                <option value="{{ $sk->id }}" {{ old('skema_id') == $sk->id ? 'selected' : '' }}>{{ $sk->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Pertanyaan <span class="text-red-500">*</span></label>
            <textarea name="pertanyaan" rows="4" required
                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                placeholder="Tuliskan teks pertanyaan di sini...">{{ old('pertanyaan') }}</textarea>
        </div>

        <div class="space-y-4">
            <h3 class="font-semibold text-sm text-gray-800 border-b pb-2">Opsi Jawaban</h3>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">PILIHAN A <span class="text-red-500">*</span></label>
                <input type="text" name="pilihan_a" value="{{ old('pilihan_a') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Tuliskan teks jawaban untuk opsi A">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">PILIHAN B <span class="text-red-500">*</span></label>
                <input type="text" name="pilihan_b" value="{{ old('pilihan_b') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Tuliskan teks jawaban untuk opsi B">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">PILIHAN C <span class="text-red-500">*</span></label>
                <input type="text" name="pilihan_c" value="{{ old('pilihan_c') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Tuliskan teks jawaban untuk opsi C">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">PILIHAN D <span class="text-red-500">*</span></label>
                <input type="text" name="pilihan_d" value="{{ old('pilihan_d') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Tuliskan teks jawaban untuk opsi D">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jawaban Benar <span class="text-red-500">*</span></label>
            <select name="jawaban_benar" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                <option value="">-- Pilih Jawaban Benar --</option>
                <option value="a" {{ old('jawaban_benar') == 'a' ? 'selected' : '' }}>Opsi A</option>
                <option value="b" {{ old('jawaban_benar') == 'b' ? 'selected' : '' }}>Opsi B</option>
                <option value="c" {{ old('jawaban_benar') == 'c' ? 'selected' : '' }}>Opsi C</option>
                <option value="d" {{ old('jawaban_benar') == 'd' ? 'selected' : '' }}>Opsi D</option>
            </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                Simpan Soal
            </button>
            <a href="{{ route('soal.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
