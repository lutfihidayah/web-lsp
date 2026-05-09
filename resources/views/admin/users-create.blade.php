@extends('admin.layout')
@section('title', 'Tambah Akun')
@section('page-title', 'User Management')

@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users') }}" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm text-gray-700 font-medium">Tambah Akun Baru</span>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="font-bold text-gray-800 text-lg">Tambah Akun</h2>
            <p class="text-sm text-gray-400 mt-1">Buat akun baru untuk user atau admin</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="Nama lengkap">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="contoh@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="08xx-xxxx-xxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Peserta)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                        <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required minlength="8"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="Ulangi password">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                    Simpan Akun
                </button>
                <a href="{{ route('admin.users') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
