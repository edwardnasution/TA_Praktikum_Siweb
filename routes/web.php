<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;

/*
Di sinilah kita mendaftarkan semua URL untuk aplikasi kita.
*/

// Route untuk Halaman Dashboard (Hanya bisa diakses kalau ada session login)
Route::get('/', function () {
    // Pengecekan session mirip seperti di PHP Native kemarin
    if (!session('login')) {
        return redirect('/login');
    }

    // Ambil categories dan brands untuk form di dashboard
    $categories = Category::all();
    $brands = Brand::all();

    // Ambil products untuk ditampilkan di dashboard
    $products = \App\Models\Product::all();

    return view('dashboard', compact('categories', 'brands', 'products'));
})->name('dashboard');

// Route untuk menampilkan form Login
Route::get('/login', [AuthController::class, 'loginView'])->name('login');

// Route untuk memproses data dari form Login (saat tombol ditekan)
Route::post('/login', [AuthController::class, 'loginAction']);

// Route untuk proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/product', [ProductController::class, 'index']);

// Brands API (used by frontend)
Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brands', [BrandController::class, 'store']);

// Named routes used by blade forms
Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
