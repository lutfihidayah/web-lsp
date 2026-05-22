@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan Akun')

@section('content')

<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Pengaturan Profil</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi akun dan password Anda</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Info Akun --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-center gap-5 mb-6">
            <div class="w-16 h-16 rounded-full bg-[#1e3a6e] flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-gray-900 text-lg">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mt-1">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <form action="{{ route('setting.update') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? '') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="08xxxxxxxxxx">
            </div>

            <hr class="border-gray-100">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Minimal 8 karakter">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Ulangi password baru">
            </div>

            <div class="pt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection