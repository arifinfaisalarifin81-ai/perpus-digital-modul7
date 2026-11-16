<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section yang Serasi dengan Halaman Pengembalian -->
            <div class="mb-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Riwayat Peminjaman Buku</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar seluruh aktivitas transaksi peminjaman dan pengembalian buku.</p>
                    </div>
                </div>
                <!-- Badge Total Riwayat -->
                <div class="hidden sm:flex items-center gap-2 bg-slate-50 border border-slate-200 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Total Riwayat: {{ $peminjamans->count() }}
                </div>
            </div>

            <!-- Card & Table Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama Anggota</th>
                                <th class="px-6 py-4">Judul Buku</th>
                                <th class="px-6 py-4">Tanggal Pinjam</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                            @forelse($peminjamans as $index => $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $item->user->name ?? 'Pengguna Dihapus' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->buku->judul ?? 'Buku Tidak Ditemukan' }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = $item->status_pengembalian ?? 'Pending';
                                        $badgeColor = match(strtolower($status)) {
                                            'sudah dikembalikan', 'dikembalikan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'disetujui', 'dipinjam' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            default => 'bg-amber-50 text-amber-700 border-amber-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-600">Tidak ada data riwayat peminjaman</p>
                                        <p class="text-xs text-slate-400 mt-1">Belum ada aktivitas transaksi yang tercatat di sistem.</p>
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