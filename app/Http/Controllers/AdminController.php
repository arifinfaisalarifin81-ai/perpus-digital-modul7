<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori; // Tambahkan model Kategori

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data dari database
        $totalBuku = Buku::count();
        $peminjamanAktif = Peminjaman::whereIn('status_peminjaman', ['Pending', 'Disetujui'])->count(); 
        $kategoriTersedia = Kategori::count(); // Menghitung total kategori

        // Mengirim data ke view admin.dashboard
        return view('admin.dashboard', compact('totalBuku', 'peminjamanAktif', 'kategoriTersedia'));
    }
}