<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan Dashboard Siswa & Menghitung Peminjaman Aktif
    public function dashboard()
    {
        // Menghitung jumlah peminjaman aktif HANYA yang statusnya 'Disetujui'
        $peminjamanAktif = Peminjaman::where('user_id', Auth::id())
                            ->where('status_peminjaman', 'Disetujui')
                            ->count();

        return view('siswa.dashboard', compact('peminjamanAktif'));
    }

    // 1. Menampilkan daftar peminjaman untuk Admin
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // 2. Form peminjaman untuk Siswa
    public function create()
    {
        $bukus = Buku::all();
        return view('siswa.peminjaman.create', compact('bukus'));
    }

    // 3. Menyimpan pengajuan peminjaman dari siswa
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Simpan data peminjaman ke database
        Peminjaman::create([
            'user_id' => Auth::id(), // Mengambil ID siswa yang sedang login
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status_peminjaman' => 'Pending', // Status awal pengajuan
        ]);

        return redirect()->route('siswa.peminjaman.riwayat')->with('success', 'Peminjaman berhasil diajukan.');
    }

    // 4. Menampilkan riwayat peminjaman HANYA untuk siswa yang sedang login
    public function riwayat()
    {
        $userId = auth()->id();

        // Mengambil data peminjaman milik siswa yang sedang login
        $peminjamans = Peminjaman::with('buku')
                        ->where('user_id', $userId)
                        ->latest()
                        ->get();

        // Menghitung statistik untuk ringkasan di atas
        $menungguCount = $peminjamans->where('status_peminjaman', 'Pending')->count();
        $dipinjamCount = $peminjamans->where('status_peminjaman', 'Disetujui')->count();
        $selesaiCount  = $peminjamans->where('status_peminjaman', 'Selesai')->count();

        return view('siswa.peminjaman.riwayat', compact('peminjamans', 'menungguCount', 'dipinjamCount', 'selesaiCount'));
    }

    // Menampilkan detail peminjaman dengan Proteksi IDOR (Soal 4)
    public function show($id)
    {
        // 1. Ambil data peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);

        // 2. Terapkan otorisasi Policy menggunakan Gate::authorize agar aman dari IDOR
        Gate::authorize('view', $peminjaman);

        // 3. Jika diizinkan, tampilkan view detail peminjaman
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function pengembalian()
    {
        // Mengambil data peminjaman yang statusnya 'Disetujui' saja
        $query = Peminjaman::with(['user', 'buku'])
                    ->where('status_peminjaman', 'Disetujui');

        // Cek apakah kolom 'status_pengembalian' ada, lalu filter agar yang sudah dikembalikan tidak muncul
        if (Schema::hasColumn('peminjamans', 'status_pengembalian')) {
            $query->where(function($q) {
                $q->whereNull('status_pengembalian')
                  ->orWhere('status_pengembalian', '!=', 'Sudah Dikembalikan');
            });
        }

        $peminjamans = $query->get();

        return view('admin.peminjaman.pengembalian', compact('peminjamans'));
    }

    public function riwayatAdmin()
    {
        // Ambil data peminjaman yang sudah selesai / riwayat untuk admin
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();

        return view('admin.peminjaman.riwayat', compact('peminjamans'));
    }

    // 5. Aksi Admin: Menyetujui Peminjaman
    public function setuju($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $dataUpdate = [
            'status_peminjaman' => 'Disetujui',
        ];

        // Cek apakah kolom tanggal kembali/jatuh tempo ada di database, lalu set otomatis +7 hari dari tanggal pinjam
        if (Schema::hasColumn('peminjamans', 'tanggal_kembali')) {
            $tanggalPinjam = $peminjaman->tanggal_pinjam ?? now();
            $dataUpdate['tanggal_kembali'] = Carbon::parse($tanggalPinjam)->addDays(7);
        } elseif (Schema::hasColumn('peminjamans', 'jatuh_tempo')) {
            $tanggalPinjam = $peminjaman->tanggal_pinjam ?? now();
            $dataUpdate['jatuh_tempo'] = Carbon::parse($tanggalPinjam)->addDays(7);
        }

        $peminjaman->update($dataUpdate);

        return back()->with('success', 'Peminjaman buku berhasil disetujui.');
    }

    // 6. Aksi Admin: Menolak Peminjaman
    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status_peminjaman' => 'Ditolak',
        ]);

        return back()->with('success', 'Peminjaman buku telah ditolak.');
    }

    // 7. Aksi Admin: Buku Dikembalikan
    public function kembali($id)
    {
        // Cari data peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);

        // Update status pengembalian menjadi 'Sudah Dikembalikan' atau 'Selesai'
        $peminjaman->update([
            'status_pengembalian' => 'Sudah Dikembalikan',
            'status_peminjaman' => 'Selesai', // Opsional: mengubah status utama menjadi selesai
            'tanggal_kembali' => now()->toDateString(), // Mencatat tanggal dikembalikan hari ini
        ]);

        // Kembalikan stok buku jika diperlukan
        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->back()->with('success', 'Pengembalian buku berhasil diverifikasi dan diselesaikan.');
    }

    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (Schema::hasColumn('peminjamans', 'status_pengembalian')) {
            $peminjaman->update([
                'status_pengembalian' => 'Diajukan'
            ]);
        }

        return back()->with('success', 'Permintaan pengembalian buku berhasil diajukan ke admin.');
    }

    // 8. Fitur Pencarian Buku (Mencegah Error 500)
    public function cari(Request $request)
    {
        $keyword = $request->input('judul');

        if (!$keyword) {
            return redirect()->back()->with('error', 'Masukkan kata kunci pencarian yang valid.');
        }

        $bukus = Buku::where('judul', 'LIKE', '%' . $keyword . '%')
                     ->orWhere('penulis', 'LIKE', '%' . $keyword . '%')
                     ->get();

        if (auth()->check() && auth()->user()->hasRole('siswa')) {
            return view('siswa.buku.index', compact('bukus'));
        }

        $kategoris = \App\Models\Kategori::all();
        return view('admin.buku.index', compact('bukus', 'kategoris'));
    }
}