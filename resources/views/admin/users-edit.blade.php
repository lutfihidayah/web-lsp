@extends('admin.layout')
@section('title', 'Edit Akun - ' . $user->name)
@section('page-title', 'User Management')

@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users') }}" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-[#1e3a6e] transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm text-gray-700 font-medium">Edit Akun: {{ $user->name }}</span>
    </div>

    {{-- User Info Card --}}
    <div class="bg-gradient-to-r from-[#1e3a6e] to-blue-700 rounded-xl p-5 mb-5 text-white flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <p class="font-bold text-lg">{{ $user->name }}</p>
            <p class="text-blue-200 text-sm">{{ $user->email }}</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full">{{ ucfirst($user->role) }}</span>
                <span class="text-xs {{ $user->status === 'aktif' ? 'bg-green-400/30' : 'bg-red-400/30' }} px-2 py-0.5 rounded-full">
                    {{ ucfirst($user->status) }}
                </span>
                <span class="text-xs text-blue-300">Sejak {{ $user->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-800 text-base mb-5">Edit Informasi Akun</h2>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                        placeholder="08xx-xxxx-xxxx">
                </div>
                <div></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700"
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User (Peserta)</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <p class="text-xs text-gray-400 mt-1">Tidak bisa mengubah role akun sendiri</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700"
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="status" value="{{ $user->status }}">
                        <p class="text-xs text-gray-400 mt-1">Tidak bisa mengubah status akun sendiri</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
