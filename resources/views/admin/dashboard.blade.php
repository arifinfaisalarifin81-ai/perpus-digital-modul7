<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Administrator') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner / Sambutan -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-6 rounded-xl shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold">Selamat Datang, Administrator</h3>
                    <p class="text-gray-300 text-sm mt-1">Kelola data buku, pantau transaksi, dan kontrol sistem perpustakaan dengan mudah.</p>
                </div>
                <span class="bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 text-xs font-semibold px-3 py-1 rounded-full">
                    Sistem Aktif
                </span>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Buku</p>
                        <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBuku }}</h4>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-lg">
                        📚
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Peminjaman Aktif</p>
                        <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamanAktif }}</h4>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-bold text-lg">
                        🔄
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori Tersedia</p>
                        <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $kategoriTersedia }}</h4>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center font-bold text-lg">
                        🏷️
                    </div>
                </div>
            </div>

            <!-- Menu Navigasi Cepat -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider border-b pb-2">Akses Cepat Menu</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/admin/buku') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                        📚 Kelola Buku
                    </a>
                    <a href="{{ url('/admin/peminjaman') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg transition shadow-sm">
                        🔄 Data Peminjaman
                    </a>
                    <a href="{{ url('/admin/pengembalian') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 text-xs font-semibold rounded-lg transition shadow-sm">
                        ✅ Pengembalian Buku
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>