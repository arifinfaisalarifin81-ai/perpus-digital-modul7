<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'max:150'], 
            'penulis'      => ['required', 'string', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1999,2026'], 
        ];
    }

    /**
     * Pesan error kustom dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'judul.required'        => 'Judul harus diisi dulu.',
            'tahun_terbit.between'  => 'Tahun terbit harus dari 1999 sampai 2026.',
            'tahun_terbit.required' => 'Tahun terbit harus diisi.',
            'kategori_id.required'  => 'Kategori harus dipilih.',
            'penulis.required'      => 'Penulis harus diisi.',
        ];
    }
}