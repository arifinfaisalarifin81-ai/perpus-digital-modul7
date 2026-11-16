<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom 'nama' bisa diisi
    protected $fillable = ['nama']; 

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}