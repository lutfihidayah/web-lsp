@extends('admin.layout')
@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">User Management</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua akun pengguna dan administrator</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
        class="flex items-center gap-2 bg-[#1e3a6e] text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Akun
    </a>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 flex items-center gap-2">
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
    {{ session('error') }}
</div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#1e3a6e" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Admin</p>
            <p class="text-2xl font-bold text-[#1e3a6e]">{{ $totalAdmin }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold text-green-700">{{ $totalUser }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Akun Aktif</p>
            <p class="text-2xl font-bold text-emerald-700">{{ $totalAktif }}</p>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex items-center gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="flex-1 min-w-48 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
        <select name="role" class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
        </select>
        <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-[#1e3a6e] text-white rounded-lg text-sm font-medium hover:bg-[#16305c] transition">Filter</button>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">Reset</a>
    </form>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr class="text-gray-400 text-xs">
                <th class="text-left px-6 py-3 font-medium">Nama / Email</th>
                <th class="text-left px-6 py-3 font-medium">No. Telepon</th>
                <th class="text-left px-6 py-3 font-medium">Role</th>
                <th class="text-left px-6 py-3 font-medium">Status</th>
                <th class="text-left px-6 py-3 font-medium">Terdaftar</th>
                <th class="text-left px-6 py-3 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 {{ $user->id === auth()->id() ? 'bg-blue-50/40' : '' }}">
                <td class="px-6 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                            {{ $user->role === 'admin' ? 'bg-[#1e3a6e] text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-blue-500 font-normal">(Anda)</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-3 text-gray-500">{{ $user->no_telepon ?? '-' }}</td>
                <td class="px-6 py-3">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $user->role === 'admin' ? 'bg-[#1e3a6e]/10 text-[#1e3a6e]' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-3">
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Klik untuk ubah status"
                            class="px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition
                            {{ $user->status === 'aktif' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-600 hover:bg-red-200' }}">
                            {{ $user->status === 'aktif' ? '✓ Aktif' : '✗ Nonaktif' }}
                        </button>
                    </form>
                </td>
                <td class="px-6 py-3 text-gray-400 text-xs">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="text-xs text-blue-600 hover:text-blue-800 font-medium">Edit</a>

                        {{-- Reset Password Modal Trigger --}}
                        <button onclick="openReset({{ $user->id }}, '{{ $user->name }}')"
                            class="text-xs text-orange-500 hover:text-orange-700 font-medium">Reset PW</button>

                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Hapus akun {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    Tidak ada akun ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- Modal Reset Password --}}
<div id="reset-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
        <h3 class="font-bold text-gray-900 mb-1">Reset Password</h3>
        <p class="text-sm text-gray-500 mb-5">Reset password untuk: <strong id="reset-name"></strong></p>
        <form id="reset-form" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                <input type="password" name="password" required minlength="8"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required minlength="8"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e]"
                    placeholder="Ulangi password baru">
            </div>
            <div class="flex gap-3 pt-1">
                <button type="submit" class="flex-1 py-2.5 bg-[#1e3a6e] text-white rounded-lg text-sm font-semibold hover:bg-[#16305c] transition">
                    Reset Password
                </button>
                <button type="button" onclick="closeReset()"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openReset(userId, userName) {
    document.getElementById('reset-name').textContent = userName;
    document.getElementById('reset-form').action = `/admin/users/${userId}/reset-password`;
    document.getElementById('reset-modal').classList.remove('hidden');
}
function closeReset() {
    document.getElementById('reset-modal').classList.add('hidden');
}
</script>

@endsection
