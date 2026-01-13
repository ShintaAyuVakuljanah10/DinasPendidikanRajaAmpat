<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\Menu;

class MenuController extends Controller
{
    public function index()
    {
        return view('backend.menu'); 
    }

    public function data()
    {
        $menus = Menu::orderBy('sort_order', 'asc')->get();
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Main,Sub',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        Menu::create($data);

        return response()->json(['message' => 'Menu berhasil dibuat']);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Main,Sub',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        $menu->update($data);

        return response()->json(['message' => 'Menu berhasil diupdate']);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json(['message' => 'Menu berhasil dihapus']);
    }
}
