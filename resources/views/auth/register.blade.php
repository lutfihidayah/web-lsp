<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sertify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- Kiri: High quality professional image --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=2070&auto=format&fit=crop" alt="Office" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#1e3a6e]/80 backdrop-blur-sm flex items-center justify-center p-16">
            <div class="max-w-md text-white">
                <h2 class="text-4xl font-extrabold mb-6 leading-tight">Wujudkan Karir Impian Bersama LSP Pro</h2>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Dapatkan sertifikasi yang diakui secara nasional dan tingkatkan kredibilitas Anda di mata perusahaan terkemuka.
                </p>
                <div class="mt-12 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="font-medium">Lisensi Resmi BNSP</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="font-medium">100+ Skema Sertifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: Form register --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Buat Akun Baru</h1>
                <p class="text-gray-500">Lengkapi data untuk memulai pendaftaran sertifikasi</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Nama Lengkap Anda"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    @error('name')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                   <label class="block text-sm font-bold text-gray-700 mb-2 ml-1" for="no_telepon">No. WhatsApp</label>
                   <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" 
                      placeholder="08xxxxxxxxxx" 
                      class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                   @error('no_telepon')
                       <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                   @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    @error('email')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required
                            placeholder="••••••••"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Konfirmasi</label>
                        <input type="password" name="password_confirmation" required
                            placeholder="••••••••"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    </div>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                @enderror

                {{-- Tombol --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-[#1e3a6e] text-white font-bold rounded-2xl hover:bg-[#16305c] shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1">
                        Daftar Akun
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 pt-4">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-[#1e3a6e] font-bold hover:underline">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>