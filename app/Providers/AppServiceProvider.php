<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Peminjaman;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS hanya saat di server production (Vercel)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Soal 3: Mendefinisikan Gate 'kelola-buku' (hanya admin dan petugas)
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole(['admin', 'petugas']);
        });

        // Soal 4: Mendaftarkan PeminjamanPolicy untuk pencegahan IDOR
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);
    }
}