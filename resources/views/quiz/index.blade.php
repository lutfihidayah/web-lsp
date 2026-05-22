@extends('layouts.app')
@section('title', 'Quiz Final')
@section('page-title', 'Quiz Final - ' . $asesmen->pendaftaran->skema->nama)

@section('content')

<div class="mb-5">
    <a href="{{ route('asesmen.show', $asesmen->id) }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Detail Asesmen
    </a>
</div>

{{-- Quiz Header --}}
<div class="bg-gradient-to-br from-[#1e3a6e] to-[#16305c] text-white rounded-xl p-6 mb-6">
    <h2 class="text-xl font-bold">Quiz Final: {{ $asesmen->pendaftaran->skema->nama }}</h2>
    <p class="text-blue-200 text-sm mt-1">Jawab 10 soal di bawah ini. Minimum nilai 60% untuk lulus.</p>
    <div class="flex gap-4 mt-3 text-sm">
        <span class="bg-white/20 px-3 py-1 rounded-full">📝 10 Soal</span>
        <span class="bg-white/20 px-3 py-1 rounded-full">⏱ Tidak ada batas waktu</span>
        <span class="bg-white/20 px-3 py-1 rounded-full">🎯 Min. 60%</span>
    </div>
</div>

<form action="{{ route('asesmen.quiz.submit', $asesmen->id) }}" method="POST" id="quizForm">
    @csrf

    @foreach($soals as $index => $soal)
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <div class="flex items-start gap-3 mb-4">
            <span class="flex-shrink-0 w-8 h-8 bg-[#1e3a6e] text-white rounded-lg flex items-center justify-center text-sm font-bold">
                {{ $index + 1 }}
            </span>
            <p class="font-medium text-gray-800 leading-relaxed pt-1">{{ $soal->pertanyaan }}</p>
        </div>

        <div class="space-y-3 ml-11">
            @foreach(['a', 'b', 'c', 'd'] as $option)
            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition group">
                <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $option }}" required
                    class="w-4 h-4 text-[#1e3a6e] focus:ring-[#1e3a6e]">
                <span class="w-6 h-6 bg-gray-100 group-hover:bg-blue-100 rounded text-xs font-bold flex items-center justify-center text-gray-500 group-hover:text-blue-700 uppercase">
                    {{ $option }}
                </span>
                <span class="text-sm text-gray-700">{{ $soal->{'pilihan_' . $option} }}</span>
            </label>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Submit --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
        <p class="text-sm text-gray-500 mb-4">Pastikan semua soal sudah dijawab sebelum submit.</p>
        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin submit quiz ini? Jawaban tidak bisa diubah.')"
            class="px-8 py-3 bg-[#1e3a6e] text-white font-bold rounded-xl hover:bg-[#16305c] transition text-sm">
            Submit Quiz
        </button>
    </div>
</form>

@endsection
