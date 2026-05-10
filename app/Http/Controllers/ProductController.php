<?php

namespace App\Http\Controllers;

use App\Models\Product; // Jangan lupa import modelnya
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk beserta relasi category dan brand
        $products = Product::with(['category', 'brand'])->get();

        // Ambil data categories dan brands untuk dropdown
        $categories = Category::all();
        $brands = Brand::all();

        // Menampilkan ke file product.blade.php dengan data tambahan
        return view('product', compact('products', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        Product::create([
            'nama_product' => $request->nama_product,
            'category_id'  => $request->category_id,
            'brand_id'     => $request->brand_id,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'foto'         => $request->foto,
            'ukuran'       => $request->ukuran,
            'material'     => $request->material,
            'deskripsi'    => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil disimpan!');
    }
}
