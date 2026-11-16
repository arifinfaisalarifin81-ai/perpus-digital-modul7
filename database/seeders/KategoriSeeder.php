<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori; // Sesuaikan dengan model kategori kamu

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::insert([
            ['nama' => 'Informatika'],
            ['nama' => 'Pemrograman'],
        ]);
    }
}