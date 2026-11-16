<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner / Hero Section yang Menarik -->
            <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-[11px] font-semibold mb-3 border border-indigo-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Portal Siswa Perpustakaan
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Riwayat & Status Peminjaman</h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">Pantau status buku yang sedang Anda pinjam, riwayat persetujuan petugas, serta tenggat waktu pengembalian dengan mudah.</p>
                    </div>
                    <a href="{{ route('siswa.peminjaman.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl text-xs font-bold shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajukan Peminjaman Baru
                    </a>
                </div>
            </div>

            <!-- Statistik Ringkas (Dinamis) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Persetujuan</div>
                        <div class="text-lg font-extrabold text-slate-800 mt-0.5">{{ $menungguCount ?? 0 }} Buku</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sedang Dipinjam</div>
                        <div class="text-lg font-extrabold text-slate-800 mt-0.5">{{ $dipinjamCount ?? 0 }} Buku</div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Selesai Dikembalikan</div>
                        <div class="text-lg font-extrabold text-slate-800 mt-0.5">{{ $selesaiCount ?? 0 }} Buku</div>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-xs flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table Card Utama -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Daftar Pengajuan Anda</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-xs">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($peminjamans ?? [] as $index => $peminjaman)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-slate-800 font-bold">{{ $peminjaman->buku->judul ?? $peminjaman->buku->title ?? 'Buku Tidak Ditemukan' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $peminjaman->tanggal_pinjam ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($peminjaman->status_peminjaman == 'Pending')
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-amber-100 text-amber-800 inline-block">Menunggu Persetujuan</span>
                                        @elseif($peminjaman->status_peminjaman == 'Disetujui')
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-blue-100 text-blue-800 inline-block">Disetujui / Dipinjam</span>
                                        @elseif($peminjaman->status_peminjaman == 'Ditolak')
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-red-100 text-red-800 inline-block">Ditolak</span>
                                        @elseif($peminjaman->status_peminjaman == 'Selesai')
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-800 inline-block">Selesai Dikembalikan</span>
                                        @else
                                            <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-slate-100 text-slate-800 inline-block">{{ $peminjaman->status_peminjaman }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @php
                                            $statusPeminjaman = $peminjaman->status_peminjaman ?? '';
                                            $statusPengembalian = $peminjaman->status_pengembalian ?? '';
                                        @endphp

                                        {{-- Tombol atau Status Pengembalian --}}
                                        @if($statusPeminjaman == 'Disetujui')
                                            @if(empty($statusPengembalian) || $statusPengembalian == '')
                                                <form action="{{ route('siswa.peminjaman.ajukan', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Ajukan pengembalian buku ini?')" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                                        Kembalikan Buku
                                                    </button>
                                                </form>
                                            @elseif($statusPengembalian == 'Diajukan')
                                                <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-amber-100 text-amber-800 inline-block">
                                                    Menunggu Verifikasi Admin
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-800 inline-block">
                                                    Sudah Dikembalikan
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-400 italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <div class="font-semibold text-slate-600 text-sm">Belum ada riwayat peminjaman</div>
                                            <p class="text-slate-400 text-xs max-w-xs">Anda belum pernah mengajukan peminjaman buku. Klik tombol ajukan peminjaman di atas untuk mulai meminjam buku.</p>
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