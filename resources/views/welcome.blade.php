<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Perpustakaan IT Digital</title>

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-950 text-white font-sans antialiased min-h-screen flex flex-col justify-between">

        <!-- Navbar / Header (Nuansa Abu-abu) -->
        <header class="w-full bg-gray-900 border-b border-gray-800 px-8 py-4 flex justify-between items-center shadow-md">
            <div class="text-lg font-bold tracking-wide text-gray-100">
                Perpustakaan IT Digital
            </div>
            <nav class="space-x-6 text-sm font-medium text-gray-300">
                <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-white transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Hero Section / Konten Utama -->
        <main class="flex-grow flex flex-col items-center justify-center text-center px-4 relative overflow-hidden py-16 bg-gradient-to-b from-gray-900 to-gray-950">
            <!-- Background Accent/Glow -->
            <div class="absolute inset-0 z-0 opacity-10 pointer-events-none bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-gray-400 via-transparent to-transparent"></div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight text-gray-100">
                    Selamat Datang di Perpustakaan IT Digital
                </h1>
                <p class="text-gray-400 text-sm md:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
                    Pusat referensi dan literatur pemrograman, software engineering, kecerdasan buatan (AI), serta arsitektur sistem modern untuk menunjang kebutuhan belajar dan ngoding kamu.
                </p>

                <!-- Tombol Aksi (Warna Abu-abu & Hijau netral) -->
                <div class="flex justify-center items-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-medium px-6 py-2.5 rounded shadow transition duration-200">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-6 py-2.5 rounded shadow transition duration-200">
                            Daftar Akun Siswa
                        </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-4 text-xs text-gray-500 bg-gray-950 border-t border-gray-900">
            &copy; {{ date('Y') }} Mustofa. All rights reserved.
        </footer>

    </body>
</html>