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
        $pages = DB::table('pages')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('backend.pages', compact('pages'));
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
            'type' => 'required|in:pages,sub_pages',
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:pages,id',
            'meta_title' => 'nullable|string|max:125',
            'active' => 'required|in:0,1',
        ]);

        $lastOrder = DB::table('pages')->max('sort_order') ?? 0;

        DB::table('pages')->insert([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'meta_title' => $request->meta_title,
            'active' => (int) $request->active,
            'sort_order' => $lastOrder + 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
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
            'type' => 'required|in:pages,sub_pages',
            'active' => 'required|in:0,1',
        ]);

        DB::table('pages')->where('id', $id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'meta_title' => $request->meta_title,
            'active' => (int) $request->active,
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if (DB::table('pages')->where('parent_id', $id)->exists()) {
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
            DB::table('pages')
                ->whereNull('parent_id')
                ->where('type', 'pages')
                ->get()
        );
    }
}
