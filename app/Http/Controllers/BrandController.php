<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_brand' => 'required|string|max:255',
        ]);

        $brand = Brand::create([
            'nama_brand' => $request->nama_brand,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $brand], 201);
        }

        return redirect()->back()->with('success', 'Brand berhasil ditambahkan');
    }

    public function index()
    {
        $brands = Brand::all();
        return response()->json(['data' => $brands]);
    }
}
