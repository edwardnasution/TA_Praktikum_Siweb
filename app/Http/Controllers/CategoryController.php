<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'nama_category' => $request->nama_category,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $category], 201);
        }

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function index()
    {
        return response()->json(['data' => Category::all()]);
    }
}
