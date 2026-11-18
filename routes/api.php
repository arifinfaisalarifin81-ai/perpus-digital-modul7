<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Models\Buku;

// Endpoint API untuk Kategori (agar dropdown tidak kosong)
Route::get('/kategoris', function () {
    return response()->json(Kategori::all());
});

// Endpoint API untuk Buku (CRUD)
Route::get('/buku', function () {
    return response()->json(Buku::with('kategori')->get());
});

Route::post('/buku', function (Request $request) {
    $validated = $request->validate([
        'kategori_id' => 'required',
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'tahun_terbit' => 'required|digits:4',
    ]);
    return response()->json(Buku::create($validated), 201);
});

Route::put('/buku/{id}', function (Request $request, $id) {
    $buku = Buku::findOrFail($id);
    $buku->update($request->all());
    return response()->json(['message' => 'Berhasil diperbarui', 'data' => $buku]);
});

Route::delete('/buku/{id}', function ($id) {
    Buku::destroy($id);
    return response()->json(['message' => 'Berhasil dihapus']);
});