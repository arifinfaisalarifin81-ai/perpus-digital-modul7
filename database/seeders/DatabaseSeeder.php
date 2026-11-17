<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role Spatie
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'petugas']);
        Role::firstOrCreate(['name' => 'siswa']);

        // 2. Buat Akun Admin Utama
        $admin1 = User::firstOrCreate(
            ['email' => 'admin@perpus.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );
        $admin1->assignRole('admin');

        // 3. Buat/Update Akun Administrator Tambahan
        $admin2 = User::updateOrCreate(
            ['email' => 'admin@perpustakaan.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('RandomSecurePasswordXYZ998#'),
            ]
        );
        $admin2->assignRole('admin');
    }
}