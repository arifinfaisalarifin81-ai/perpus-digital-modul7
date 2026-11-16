<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Header -->
            <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-[11px] font-semibold mb-3 border border-indigo-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Katalog Perpustakaan
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Daftar Koleksi Buku</h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">Jelajahi berbagai judul buku menarik yang tersedia untuk dibaca dan dipinjam.</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Buku untuk Siswa -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Katalog Buku Tersedia</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-4 text-center font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse(isset($bukus) ? $bukus : [] as $index => $buku)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    
                                    <!-- Aman dari error jika kategori null -->
                                    <td class="px-6 py-4 text-slate-600 font-semibold">
                                        {{ $buku->kategori->nama_kategori ?? ($buku->kategori->nama ?? 'Umum') }}
                                    </td>
                                    
                                    <!-- Judul Buku aman dari XSS (Soal 2) -->
                                    <td class="px-6 py-4 text-slate-800 font-bold">{{ $buku->judul ?? ($buku->title ?? '-') }}</td>
                                    
                                    <td class="px-6 py-4 text-slate-600">{{ $buku->penulis ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('siswa.peminjaman.create') }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-[11px] font-semibold shadow-sm transition inline-block">
                                            Pinjam Buku
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <span class="font-semibold text-slate-600 text-sm">Belum ada data buku tersedia.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>