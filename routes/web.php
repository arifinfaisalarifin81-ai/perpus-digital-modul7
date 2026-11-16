<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


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
    

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('buku', BukuController::class);
        Route::resource('users', UserController::class);
        
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
        Route::get('/riwayat', [PeminjamanController::class, 'riwayatAdmin'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setuju'])->name('peminjaman.setuju');
        Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('pengembalian.update');
    });


    Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('buku', BukuController::class);
        
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
        Route::get('/riwayat', [PeminjamanController::class, 'riwayatAdmin'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setuju'])->name('peminjaman.setuju');
        Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('pengembalian.update');
    });


    Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [PeminjamanController::class, 'dashboard'])->name('dashboard');
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
        
        Route::patch('/peminjaman/{id}/ajukan', [PeminjamanController::class, 'ajukanPengembalian'])->name('peminjaman.ajukan');
    });

    // Route Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 
    Route::get('/buku-cari', function (\Illuminate\Http\Request $request) {
        $judul = $request->input('judul');
        // Vulnerable raw query concatenation
        $hasil = \Illuminate\Support\Facades\DB::select("SELECT * FROM bukus WHERE judul = '$judul'");
        return response()->json($hasil);
    });

    // A3: Celah CSRF / Forced Browsing (Route GET untuk hapus buku)
    Route::get('/buku/{buku}/hapus', [BukuController::class, 'destroy']);

    // A4: Celah IDOR pada detail peminjaman tanpa cek kepemilikan
    Route::get('/peminjaman/{id}', function ($id) {
        $peminjaman = \App\Models\Peminjaman::findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    });

    Route::get('/peminjaman/{id}', function ($id) {
    $peminjaman = \App\Models\Peminjaman::findOrFail($id);
    return view('peminjaman.show', compact('peminjaman'));
    })->middleware(['auth']);

});

    Route::middleware(['auth', 'can:kelola-buku'])->group(function () {
    // Route untuk tambah, edit, hapus buku ditaruh di sini
    Route::resource('buku', BukuController::class);
});


require __DIR__.'/auth.php';