<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.category');
    }

    public function data()
    {
        return response()->json(Category::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:categories,nama',
            'icon' => 'nullable|string'
        ]);

        Category::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon,
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(Category::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:categories,nama,' . $id,
            'icon' => 'nullable|string'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'icon' => $request->icon
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
