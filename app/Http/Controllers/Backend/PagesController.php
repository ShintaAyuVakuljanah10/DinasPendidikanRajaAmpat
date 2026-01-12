<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\Pages;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        // $pages = Pages::orderBy('order', 'asc')->get();

        return view('backend.pages' );
    }

    public function data()
    {
        // Ambil semua pages
        $pages = Pages::where('type', 'Pages')->orderBy('sort_order', 'asc')->get();

        // Bisa return id dan title saja supaya ringan
        return response()->json($pages->map(function($page) {
            return [
                'id' => $page->id,
                'title' => $page->title,
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug'  => 'required|unique:pages,slug',
            'type'  => 'required|in:Pages,Sub Pages',
        ]);

        Pages::create([
            'title'     => $request->title,
            'slug'      => $request->slug,
            'type'      => $request->type,
            'parent_id' => $request->parent_id,
            'active'    => 1,
            'sort_order'=> 0,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        return Pages::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $page = Pages::findOrFail($id);
        $page->update([
            'title'      => $request->title,
            'slug'       => $request->slug,
            'content'    => $request->content,
            'type'       => $request->type,
            'parent_id'  => $request->parent_id,
            'active'     => $request->active ?? 1,
            'sort_order' => 0,
            'meta_title' => $request->meta_title,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $page = Pages::findOrFail($id);
        $page->delete();
        return response()->json(['success' => true]);
    }

}
