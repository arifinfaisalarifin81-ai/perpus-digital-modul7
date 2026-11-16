<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'judul',
        'penulis',
        'tahun_terbit',
    ];

   
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // // Relasi ke Peminjaman (jika diperlukan)
    // public function peminjaman()
    // {
    //     return $this->hasMany(Peminjaman::class);
    // }
}