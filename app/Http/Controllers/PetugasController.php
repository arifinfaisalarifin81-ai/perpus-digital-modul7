<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasController extends Controller
 {
    public function index()
    {
        return view('petugas.dashboard'); // Sesuaikan dengan nama view dashboard petugas Anda
    }
}