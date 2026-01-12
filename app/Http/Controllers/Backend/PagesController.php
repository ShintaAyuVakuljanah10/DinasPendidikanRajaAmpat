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
        return response()->json(
            Pages::orderBy('sort_order', 'asc')->get()
        );
    }

    public function store(Request $request)
    {
        Pages::create([
            'title'      => $request->title,
            'slug'       => $request->slug,
            'content'    => $request->content,
            'type'       => $request->type,
            'parent'     => $request->parent_id,
            'active'     => $request->active ?? 1,
            'order'      => 0,
            'meta_title' => $request->meta_title,
        ]);

        return response()->json(['success' => true]);
    }
}
