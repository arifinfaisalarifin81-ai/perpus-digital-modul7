<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Validasi Error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Tambah Buku (Hanya Admin dan Petugas) -->
            @role('admin|petugas')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    ➕ Tambah Buku Baru
                </h3>
                
                <form action="{{ route('buku.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Judul Buku</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Pemrograman Web Lanjut" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Penulis</label>
                            <input type="text" name="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2026" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Stok</label>
                            <input type="number" name="stok" value="{{ old('stok') }}" placeholder="Jumlah stok..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150 ease-in-out">
                            💾 Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
            @endrole

            <!-- Daftar Koleksi Buku -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">📚 Daftar Koleksi Buku</h3>
                    <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        Total: {{ isset($buku) ? count($buku) : 0 }} Buku
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="px-6 py-3">Judul Buku</th>
                                <th class="px-6 py-3">Penulis</th>
                                <th class="px-6 py-3">Penerbit</th>
                                <th class="px-6 py-3">Tahun</th>
                                <th class="px-6 py-3">Stok</th>
                                @role('admin|petugas')
                                <th class="px-6 py-3 text-center">Aksi</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                            @isset($buku)
                                @forelse($buku as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->judul }}</td>
                                    <td class="px-6 py-4">{{ $item->penulis }}</td>
                                    <td class="px-6 py-4">{{ $item->penerbit }}</td>
                                    <td class="px-6 py-4">{{ $item->tahun_terbit }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    @role('admin|petugas')
                                    <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                        <a href="{{ route('buku.edit', $item->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-xs font-semibold shadow">Edit</a>
                                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold shadow">Hapus</button>
                                        </form>
                                    </td>
                                    @endrole
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">
                                        Belum ada data buku yang tersimpan di sistem.
                                    </td>
                                </tr>
                                @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>