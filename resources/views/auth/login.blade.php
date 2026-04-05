<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LSP Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex">

    {{-- Kiri: Background biru dengan pattern --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#1e3a6e] relative overflow-hidden items-center justify-center">
        {{-- Pattern sertifikat --}}
        <div class="absolute inset-0 opacity-20">
            @for ($i = 0; $i < 40; $i++)
                <div class="inline-block m-4 text-white">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                        <rect x="5" y="5" width="50" height="40" rx="3" stroke="white" stroke-width="2"/>
                        <line x1="12" y1="18" x2="48" y2="18" stroke="white" stroke-width="1.5"/>
                        <line x1="12" y1="24" x2="48" y2="24" stroke="white" stroke-width="1.5"/>
                        <line x1="12" y1="30" x2="35" y2="30" stroke="white" stroke-width="1.5"/>
                        <circle cx="30" cy="52" r="7" stroke="white" stroke-width="2"/>
                        <line x1="23" y1="52" x2="37" y2="52" stroke="white" stroke-width="1.5"/>
                    </svg>
                </div>
            @endfor
        </div>
    </div>

    {{-- Kanan: Form login --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">Wellcome LSP Pro</h1>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="Masukan Email"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        placeholder="Masukan Password"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-[#1e3a6e] text-gray-700">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Login --}}
                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('register') }}" class="text-sm text-gray-500">
                        Already have an account? <span class="text-[#1e3a6e] font-semibold">Sign up</span>
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-[#1e3a6e] text-white font-semibold rounded-lg hover:bg-[#16305c] transition">
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>