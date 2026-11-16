<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ $buku->judul }}</h3>
                <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                <p><strong>Penerbit:</strong> {{ $buku->penerbit ?? '-' }}</p>
                <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit ?? '-' }}</p>
                <p><strong>Stok:</strong> {{ $buku->stok }}</p>

                <div class="mt-6">
                    <a href="{{ route('buku.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>