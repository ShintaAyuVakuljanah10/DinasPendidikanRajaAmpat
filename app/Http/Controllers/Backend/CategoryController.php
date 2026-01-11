<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // halaman view
    public function index()
    {
        return view('backend.category');
    }

    // ambil data
    public function data()
    {
        return response()->json(Category::latest()->get());
    }

    // simpan
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:categories,nama'
        ]);

        Category::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return response()->json(['success' => true]);
    }

    // edit (ambil data)
    public function edit($id)
    {
        return response()->json(Category::findOrFail($id));
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:categories,nama,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return response()->json(['success' => true]);
    }

    // hapus
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
