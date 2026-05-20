<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $products = product::with('category')->get();
        return view('product', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
    $validateData = $request->validate([
        'product_name'   => 'required|string|max:255',
        'category_id'    => 'required|exists:categories,category_id',
        'product_price'  => 'required|numeric',
        'product_stock'  => 'required|integer',
        'product_image'  => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    // Cek apakah ada file gambar
    if ($request->hasFile('product_image')) {
        // Simpan ke storage/app/public/products
        $imagePath = $request->file('product_image')->store('products', 'public');

        // Simpan path ke database
        $validateData['product_image'] = $imagePath;
    }

    // Simpan ke database
    Product::create($validateData);

    return redirect()->route('products')
        ->with('success', 'Produk berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Ambil data produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Validasi input
    $validateData = $request->validate([
        'product_name'   => 'required|string|max:255',
        'category_id'    => 'required|exists:categories,category_id',
        'product_price'  => 'required|numeric',
        'product_stock'  => 'required|integer',
        'product_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    // Jika user upload gambar baru
    if ($request->hasFile('product_image')) {

        // Hapus gambar lama jika ada
        if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
            Storage::disk('public')->delete($product->product_image);
        }

        // Simpan gambar baru
        $imagePath = $request->file('product_image')->store('products', 'public');

        // Masukkan ke data yang akan diupdate
        $validateData['product_image'] = $imagePath;
    }

    // Update ke database
    $product->update($validateData);

    return redirect()->route('products')
        ->with('success', 'Produk berhasil diupdate!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         // Ambil data produk
    $product = Product::findOrFail($id);

    // Hapus gambar dari storage jika ada
    if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
        Storage::disk('public')->delete($product->product_image);
    }

    // Hapus data dari database
    $product->delete();

    return redirect()->route('products')
        ->with('deleted', 'Produk berhasil dihapus!');

    }
}
