<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Peminjaman;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // Route Global Daftar Buku (Metode GET agar tidak terjadi error 405)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    // Group Route Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('buku', BukuController::class)->except(['index']);
        Route::resource('users', UserController::class);
        
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
        Route::get('/riwayat', [PeminjamanController::class, 'riwayatAdmin'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setuju'])->name('peminjaman.setuju');
        Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('pengembalian.update');
    });

    // Group Route Petugas
    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('buku', BukuController::class)->except(['index']);
        
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
        Route::get('/riwayat', [PeminjamanController::class, 'riwayatAdmin'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setuju'])->name('peminjaman.setuju');
        Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('pengembalian.update');
    });

    // Group Route Siswa
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [PeminjamanController::class, 'dashboard'])->name('dashboard');
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/ajukan', [PeminjamanController::class, 'ajukanPengembalian'])->name('peminjaman.ajukan');
    });

    // Route Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Pencarian Buku (SIMULASI RENTAN SQL INJECTION UNTUK SOAL NO. 1)
    Route::get('/buku-cari', function (Request $request) {
        $judul = $request->input('judul');
        
        // Sengaja menggunakan string interpolation tanpa parameter binding agar rentan
        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");
        
        return response()->json($hasil);
    });

    // Detail Peminjaman (Diamankan dari Celah IDOR)
    Route::get('/peminjaman/{id}', function ($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $user = auth()->user();
        if (!$user->hasRole(['admin', 'petugas']) && $peminjaman->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('peminjaman.show', compact('peminjaman'));
    })->name('peminjaman.show');

});

// Route Pengelolaan Buku Berbasis Gate 'kelola-buku' (Admin & Petugas)
Route::middleware(['auth', 'can:kelola-buku'])->group(function () {
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

require __DIR__.'/auth.php';