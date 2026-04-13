@extends('admin.layout')

@section('title', 'Tambah Peserta')
@section('page-title', 'Tambah Peserta')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.peserta') }}"
                class="p-2 hover:bg-gray-100 rounded-lg text-gray-500">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Tambah Peserta Baru</h2>
                <p class="text-sm text-gray-400">Isi data peserta sertifikasi</p>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.peserta.store') }}">
            @csrf

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        placeholder="Masukan nama lengkap"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="Masukan email"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                        placeholder="Masukan no. telepon"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="3"
                        placeholder="Masukan alamat lengkap"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Skema Sertifikasi <span class="text-red-500">*</span></label>
                    <select name="skema_id" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent text-gray-700">
                        <option value="">-- Pilih Skema --</option>
                        @foreach($skemas as $skema)
                            <option value="{{ $skema->id }}" {{ old('skema_id') == $skema->id ? 'selected' : '' }}>
                                {{ $skema->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] focus:border-transparent text-gray-700">
                        <option value="">-- Pilih Status --</option>
                        <option value="Verifikasi" {{ old('status') == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="Asesmen" {{ old('status') == 'Asesmen' ? 'selected' : '' }}>Asesmen</option>
                        <option value="Dalam Proses" {{ old('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Kompeten" {{ old('status') == 'Kompeten' ? 'selected' : '' }}>Kompeten</option>
                        <option value="Belum Kompeten" {{ old('status') == 'Belum Kompeten' ? 'selected' : '' }}>Belum Kompeten</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit"
                    class="px-6 py-3 bg-[#1e3a6e] text-white text-sm font-medium rounded-lg hover:bg-[#16305c] transition">
                    Simpan Peserta
                </button>
                <a href="{{ route('admin.peserta') }}"
                    class="px-6 py-3 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

@endsection