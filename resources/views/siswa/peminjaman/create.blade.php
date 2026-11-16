<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Ajukan Peminjaman Buku</h2>
                <p class="text-xs text-gray-500 mt-0.5">Silakan pilih buku yang ingin dipinjam dari daftar perpustakaan.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <form action="{{ route('siswa.peminjaman.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Pilih Buku -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Buku</label>
                        <select name="buku_id" class="w-full text-xs border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Buku --</option>
                            @isset($bukus)
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id }}">{{ $buku->judul ?? $buku->title ?? 'Buku Tanpa Judul' }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="mb-4">
                    <label for="tanggal_pinjam" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('siswa.dashboard') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm">Kirim Pengajuan</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>