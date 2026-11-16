<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori; // 1. Tambahkan import model Kategori
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku (dipisahkan berdasarkan role yang sedang login).
     */
    public function index()
    {
        $bukus = Buku::all();
        $kategoris = Kategori::all(); // 2. Ambil semua data kategori untuk dropdown form admin

        // Jika yang login adalah siswa, arahkan ke tampilan khusus siswa (tanpa form input)
        if (auth()->user()->hasRole('siswa')) {
            return view('siswa.buku.index', compact('bukus'));
        }

        // Jika admin atau petugas, tampilkan halaman manajemen buku lengkap beserta data kategorinya
        return view('admin.buku.index', compact('bukus', 'kategoris'));
    }

    /**
     * Menampilkan form tambah buku (Hanya untuk Admin/Petugas).
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required', // 3. Pastikan kolom kategori divalidasi
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
        ]);

        Buku::create($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail buku tertentu.
     */
    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Memperbarui data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
        ]);

        $buku->update($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Menghapus data buku dari database.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}