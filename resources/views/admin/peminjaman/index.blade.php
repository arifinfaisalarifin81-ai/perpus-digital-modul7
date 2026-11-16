<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gray-100 text-gray-700 rounded-xl border border-gray-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Daftar Peminjaman Buku</h2>
                        <p class="text-sm text-gray-500 mt-0.5">Kelola dan pantau seluruh transaksi peminjaman buku perpustakaan secara real-time.</p>
                    </div>
                </div>
                
                <!-- Badge Total Data -->
                <div class="bg-gray-50 border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-xs font-bold flex items-center shadow-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-gray-600 mr-2.5 animate-pulse"></span>
                    Total Data: <span class="text-gray-900 ml-1.5 text-sm">{{ count($peminjamans ?? []) }}</span>
                </div>
            </div>

            <!-- Card Wrapper untuk Tabel -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-left text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Anggota</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Peminjaman</th>
                                <th scope="col" class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status Pengembalian</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($peminjamans ?? [] as $index => $peminjaman)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-500 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-xs font-bold text-gray-900">{{ $peminjaman->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-xs text-gray-800 font-semibold">{{ $peminjaman->buku->judul ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 font-medium">
                                        {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($peminjaman->status_peminjaman == 'Disetujui')
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Disetujui</span>
                                        @elseif($peminjaman->status_peminjaman == 'Pending')
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                        @else
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-200">{{ $peminjaman->status_peminjaman }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        @php
                                            $statusPengembalian = $peminjaman->status_pengembalian ?? '';
                                        @endphp

                                        @if($statusPengembalian == 'Diajukan')
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">Menunggu Verifikasi</span>
                                        @elseif($statusPengembalian == 'Sudah Dikembalikan' || $peminjaman->status_peminjaman == 'Selesai')
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">Sudah Dikembalikan</span>
                                        @elseif($peminjaman->status_peminjaman == 'Disetujui')
                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full bg-gray-100 text-gray-600 border border-gray-200">Belum Dikembalikan</span>
                                        @else
                                            <span class="text-gray-400 font-bold text-base inline-block">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium">
                                        <div class="inline-flex items-center gap-2 justify-center">
                                            @if($peminjaman->status_peminjaman == 'Pending')
                                                <!-- Tombol Setuju Modern -->
                                                <form action="{{ route('admin.peminjaman.setuju', $peminjaman->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="group relative inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-lg shadow-sm hover:shadow transition-all duration-200 active:scale-95">
                                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Setuju
                                                    </button>
                                                </form>

                                                <!-- Tombol Tolak Modern -->
                                                <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="group relative inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold rounded-lg shadow-sm hover:shadow transition-all duration-200 active:scale-95" onclick="return confirm('Yakin ingin menolak peminjaman ini?')">
                                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @elseif($peminjaman->status_pengembalian == 'Diajukan')
                                                <!-- Tombol Terima Pengembalian oleh Admin -->
                                                <form action="{{ route('admin.peminjaman.kembali', $peminjaman->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="group relative inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-lg shadow-sm hover:shadow transition-all duration-200 active:scale-95" onclick="return confirm('Terima pengembalian buku ini?')">
                                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Terima Buku
                                                    </button>
                                                </form>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-gray-500 bg-gray-100 rounded-lg border border-gray-200">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-3 border border-gray-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-700">Belum ada data peminjaman buku</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Data transaksi peminjaman baru akan muncul di sini secara otomatis.</p>
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