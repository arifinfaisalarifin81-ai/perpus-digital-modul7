<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Panggil model User jika ingin menampilkan data user

class UserController extends Controller
{
    public function index()
    {
        // Contoh mengambil data user untuk dikirim ke view
        $users = User::all();
        
        // Sesuaikan nama view dengan file blade Anda (misal: resources/views/admin/users/index.blade.php)
        return view('admin.users.index', compact('users'));
    }
}