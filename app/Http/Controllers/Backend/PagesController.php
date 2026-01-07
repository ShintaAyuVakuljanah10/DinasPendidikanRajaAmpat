<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        return view('backend.pages');
    }

    public function getDatatables()
    {
        return response()->json(DB::table('pages')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:pages,title',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'type' => 'required|string',
            'content' => 'nullable|string',
            'parent' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:125',
            'meta_keywords' => 'nullable|string',
            'active' => 'required|boolean',
            'with_content' => 'nullable|boolean',
            'with_direct_link' => 'nullable|boolean',
            'link' => 'nullable|string|max:255',
        ]);

        $lastOrder = DB::table('pages')->max('order') ?? 0;

        DB::table('pages')->insert([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'type' => $request->type,
            'parent' => $request->parent,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'active' => $request->active,
            'with_content' => $request->with_content ?? 0,
            'with_direct_link' => $request->with_direct_link ?? 0,
            'link' => $request->link,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'order' => $lastOrder + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(
            DB::table('pages')->where('id', $id)->first()
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:pages,title,' . $id,
            'slug' => 'required|string|max:255|unique:pages,slug,' . $id,
            'type' => 'required|string',
            'active' => 'required|boolean',
        ]);

        DB::table('pages')->where('id', $id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'type' => $request->type,
            'parent' => $request->parent,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'active' => $request->active,
            'with_content' => $request->with_content ?? 0,
            'with_direct_link' => $request->with_direct_link ?? 0,
            'link' => $request->link,
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if (DB::table('pages')->where('parent', $id)->exists()) {
            return response()->json([
                'message' => 'Page masih memiliki sub pages'
            ], 422);
        }

        DB::table('pages')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function getParent()
    {
        return response()->json(
            DB::table('pages')->whereNull('parent')->get()
        );
    }
}
