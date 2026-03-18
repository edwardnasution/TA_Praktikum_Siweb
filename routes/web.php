<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
Di sinilah kita mendaftarkan semua URL untuk aplikasi kita.
*/

// Route untuk Halaman Dashboard (Hanya bisa diakses kalau ada session login)
Route::get('/', function () {
    // Pengecekan session mirip seperti di PHP Native kemarin
    if (!session('login')) {
        return redirect('/login');
    }
    return view('dashboard'); // Memanggil file resources/views/dashboard.blade.php
})->name('dashboard');

// Route untuk menampilkan form Login
Route::get('/login', [AuthController::class, 'loginView'])->name('login');

// Route untuk memproses data dari form Login (saat tombol ditekan)
Route::post('/login', [AuthController::class, 'loginAction']);

// Route untuk proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');