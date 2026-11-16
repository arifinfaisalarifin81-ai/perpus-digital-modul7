<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Resources\BukuResource;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return BukuResource::collection($buku);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1999|max:2026',
        ], [
            // Pesan error kustom bahasa Indonesia untuk fungsi store
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kategori_id.exists'    => 'Kategori yang dipilih tidak valid.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.max'             => 'Judul buku maksimal 255 karakter.',
            'penulis.required'      => 'Nama penulis wajib diisi.',
            'penulis.max'           => 'Nama penulis maksimal 255 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'      => 'Tahun terbit minimal adalah 1999.',
            'tahun_terbit.max'      => 'Tahun terbit maksimal adalah 2026.',
        ]);

        $buku = Buku::create($validated);

        return response()->json($buku, 201);
    }

    // Detail
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku, 200);
    }

    // Memperbarui data buku
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'kategori_id'  => 'sometimes|exists:kategoris,id',
            'judul'        => 'sometimes|string|max:255',
            'penulis'      => 'sometimes|string|max:255',
            'tahun_terbit' => 'sometimes|integer|min:1999|max:2026',
        ], [
            // Pesan error kustom bahasa Indonesia untuk fungsi update
            'kategori_id.exists'    => 'Kategori yang dipilih tidak valid.',
            'judul.max'             => 'Judul buku maksimal 255 karakter.',
            'penulis.max'           => 'Nama penulis maksimal 255 karakter.',
            'tahun_terbit.integer'  => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'      => 'Tahun terbit minimal adalah 1999.',
            'tahun_terbit.max'      => 'Tahun terbit maksimal adalah 2026.',
        ]);

        $buku->update($validated);

        return response()->json($buku, 200);
    }

    /**
     * Menghapus data buku
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}