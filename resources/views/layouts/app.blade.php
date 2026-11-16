<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between min-h-screen sticky top-0 shadow-md">
            <div>
                <!-- Brand / Logo -->
                <div class="px-6 py-5 border-b border-slate-800 flex items-center gap-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="font-bold text-sm tracking-wider text-white">PERPUSTAKAAN</span>
                </div>

                <!-- Menu Navigasi -->
                <nav class="px-3 py-4 space-y-5 text-xs font-medium">
                    
                    <!-- MENU UTAMA -->
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-500 px-3 mb-2 tracking-wider">MENU UTAMA</div>
                        <ul class="space-y-1">
                            @role('admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Dasbor</a>
                            </li>
                            @endrole
                            @role('petugas')
                            <li>
                                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Dasbor</a>
                            </li>
                            @endrole
                            @role('siswa')
                            <li>
                                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Dasbor</a>
                            </li>
                            @endrole

                            <li>
                                @role('admin')
                                    <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">
                                @elserole('petugas')
                                    <a href="{{ route('petugas.buku.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">
                                @else
                                    <a href="{{ route('siswa.buku.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">
                                @endrole
                                    Daftar Buku
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- MANAJEMEN (Hanya Admin)[cite: 7, 9, 10] -->
                    @role('admin')
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-500 px-3 mb-2 tracking-wider">MANAJEMEN</div>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">
                                    Kelola Pengguna
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">
                                    Kelola Peran
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endrole

                   <!-- TRANSAKSI -->
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-500 px-3 mb-2 tracking-wider">TRANSAKSI</div>
                        <ul class="space-y-1">
                            @role('admin')
                            <li>
                                <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Peminjaman</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.peminjaman.pengembalian') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Pengembalian</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.peminjaman.riwayat') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Riwayat Peminjaman</a>
                            </li>
                            @endrole

                            @role('petugas')
                            <li>
                                <a href="{{ route('petugas.peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Peminjaman</a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.peminjaman.pengembalian') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Pengembalian</a>
                            </li>
                            <li>
                                <a href="{{ route('petugas.peminjaman.riwayat') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Riwayat Peminjaman</a>
                            </li>
                            @endrole

                            @role('siswa')
                            <li>
                                <a href="{{ route('siswa.peminjaman.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Ajukan Peminjaman</a>
                            </li>
                            <li>
                                <a href="{{ route('siswa.peminjaman.riwayat') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Riwayat Peminjaman</a>
                            </li>
                            @endrole
                        </ul>
                    </div>

                    <!-- AKUN -->
                    <div>
                        <div class="text-[10px] font-bold uppercase text-slate-500 px-3 mb-2 tracking-wider">AKUN</div>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Profil Saya</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800 hover:text-white transition">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </nav>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white shadow-sm border-b border-gray-200 px-8 py-3.5 flex justify-between items-center">
                <div class="text-xs text-gray-500 font-medium">Modul V: Autentikasi & RBAC</div>
                <div class="text-xs font-bold text-gray-700">
                    @auth {{ auth()->user()->name }} (@role('admin') Admin @elserole('petugas') Petugas @else Siswa @endrole) @endauth
                </div>
            </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>