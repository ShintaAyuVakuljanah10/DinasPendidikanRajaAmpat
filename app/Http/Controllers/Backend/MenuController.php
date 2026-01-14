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
        return Menu::orderBy('sort_order')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'active'=> 'required|boolean',
        ]);

        // auto urutan terakhir
        $data['sort_order'] = Menu::max('sort_order') + 1;

        Menu::create($data);

        return response()->json(['message' => 'Menu berhasil dibuat']);
    }

    public function show($id)
    {
        return Menu::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'active'=> 'required|boolean',
        ]);

        $menu->update($data);

        return response()->json(['message' => 'Menu berhasil diupdate']);
    }

    public function destroy($id)
    {
        Menu::findOrFail($id)->delete();

        return response()->json(['message' => 'Menu berhasil dihapus']);
    }
}
