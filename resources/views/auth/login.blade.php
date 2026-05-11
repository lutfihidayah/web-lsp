<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LSP Profesional</title>
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
        <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=1974&auto=format&fit=crop" alt="Workspace" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#1e3a6e]/80 backdrop-blur-sm flex items-center justify-center p-16">
            <div class="max-w-md text-white">
                <h2 class="text-4xl font-extrabold mb-6 leading-tight">Mulai Perjalanan Karir Profesional Anda</h2>
                <p class="text-blue-100 text-lg leading-relaxed">
                    Akses dashboard Anda untuk mengelola sertifikasi, jadwal asesmen, dan profil kompetensi Anda dalam satu platform terintegrasi.
                </p>
                <div class="mt-12 flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-[#1e3a6e] object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=100&auto=format&fit=crop" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-[#1e3a6e] object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&auto=format&fit=crop" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-[#1e3a6e] object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=100&auto=format&fit=crop" alt="">
                    </div>
                    <p class="text-sm text-blue-100 font-medium">Bergabung dengan 10k+ profesional lainnya</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: Form login --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang</h1>
                <p class="text-gray-500">Silakan masuk ke akun LSP Profesional Anda</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="nama@email.com"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    @error('email')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password</label>
                    <input type="password" name="password" required
                        placeholder="••••••••"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#1e3a6e] focus:ring-0 transition-all outline-none text-gray-700">
                    @error('password')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#1e3a6e] focus:ring-[#1e3a6e]">
                        <span class="text-sm text-gray-500">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#1e3a6e] hover:underline">Lupa Password?</a>
                    @endif
                </div>

                {{-- Tombol Login --}}
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-4 bg-[#1e3a6e] text-white font-bold rounded-2xl hover:bg-[#16305c] shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-1">
                        Masuk Sekarang
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 pt-4">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-[#1e3a6e] font-bold hover:underline">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>