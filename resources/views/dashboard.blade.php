<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Selamat Datang yang Elegan -->
            <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-[11px] font-semibold mb-3 border border-indigo-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Portal Siswa Perpustakaan Digital
                        </div>
                        <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-xl">Jelajahi ribuan koleksi buku yang tersedia di perpustakaan sekolah dan ajukan peminjaman dengan cepat dan mudah.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('siswa.buku.index') }}" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-indigo-600/30 transition transform hover:-translate-y-0.5">
                            Cari Buku
                        </a>
                        <a href="{{ route('siswa.peminjaman.create') }}" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl text-xs font-bold shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                            Ajukan Pinjam
                        </a>
                    </div>
                </div>
            </div>

            <!-- Grid Statistik / Informasi Cepat -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Katalog Buku</div>
                        <div class="text-xl font-extrabold text-slate-800 mt-0.5">Tersedia</div>
                        <a href="{{ route('siswa.buku.index') }}" class="text-[11px] font-semibold text-indigo-600 hover:underline mt-1 inline-block">Lihat Daftar Buku &rarr;</a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Peminjaman Aktif</div>
                        <div class="text-xl font-extrabold text-slate-800 mt-0.5">0 Buku</div>
                        <a href="{{ route('siswa.peminjaman.riwayat') }}" class="text-[11px] font-semibold text-amber-600 hover:underline mt-1 inline-block">Cek Status &rarr;</a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Akun</div>
                        <div class="text-xl font-extrabold text-emerald-600 mt-0.5">Aktif</div>
                        <span class="text-[11px] font-medium text-slate-400 mt-1 inline-block">Role: Siswa</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>