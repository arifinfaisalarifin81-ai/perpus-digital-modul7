<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gray-100 text-gray-700 rounded-xl border border-gray-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pengembalian Buku</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Kelola proses pengembalian buku dan verifikasi denda keterlambatan.</p>
                    </div>
                </div>
                
                <!-- Badge Total Data Aktif Dipinjam -->
                <div class="bg-gray-50 border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center shadow-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 mr-2.5 animate-pulse"></span>
                    Buku Dipinjam: <span class="text-gray-900 ml-1.5 text-sm">{{ count($peminjamans ?? []) }}</span>
                </div>
            </div>

            <!-- Card Wrapper untuk Tabel -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Anggota</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <!-- Kolom Aksi diubah ke tengah (text-center) -->
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($peminjamans as $index => $peminjaman)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $peminjaman->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800 font-semibold">{{ $peminjaman->buku->judul ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">Sedang Dipinjam</span>
                                    </td>
                                    <!-- Isi Kolom Aksi diubah ke tengah (text-center) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @php
                                            $statusPengembalian = $peminjaman->status_pengembalian ?? null;
                                        @endphp

                                        @if($statusPengembalian == 'Diajukan')
                                            <!-- Tombol Terima Buku hanya muncul jika siswa sudah mengajukan -->
                                            <form action="{{ route('admin.pengembalian.update', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Proses pengembalian buku ini?')" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-2xs">
                                                    Terima Buku
                                                </button>
                                            </form>
                                        @else
                                            <!-- Tulisan diubah menjadi 'Belum di Kembalikan' -->
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-amber-800 bg-amber-50 border border-amber-200 rounded-lg">
                                                Belum di Kembalikan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-4 border border-gray-200">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-base font-bold text-gray-700">Tidak ada buku yang sedang dipinjam</p>
                                            <p class="text-sm text-gray-400 mt-1">Semua buku perpustakaan saat ini berada di rak atau sudah dikembalikan.</p>
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