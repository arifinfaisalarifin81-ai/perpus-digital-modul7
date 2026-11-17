<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Peminjaman;
use App\Policies\PeminjamanPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Soal 3: Mendefinisikan Gate 'kelola-buku' (hanya admin dan petugas)
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole(['admin', 'petugas']);
        });

        // Soal 4: Mendaftarkan PeminjamanPolicy untuk pencegahan IDOR
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);
    }
}