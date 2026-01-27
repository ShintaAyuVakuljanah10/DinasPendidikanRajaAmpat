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
        $pages = Pages::with('parent')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json($pages->map(function ($page) {
            return [
                'id'         => $page->id,
                'title'      => $page->title,
                'type'       => $page->type,
                'parent'     => $page->parent?->title ?? '-',
                'active'     => (int) $page->active,
                'sort_order' => $page->sort_order ?? 0,
            ];
        }));
    }
    
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug'  => 'required|unique:pages,slug',
            'type'  => 'required|in:Pages,Sub Pages',
            'content' => 'nullable',
            'meta_title' => 'nullable'
        ];

        if ($request->type === 'Sub Pages') {
            $rules['parent_id'] = 'required|exists:pages,id';
        }

        $request->validate($rules);
        $parentId = $request->type === 'Sub Pages'
            ? $request->parent_id
            : null;

        $lastOrder = Pages::where('parent_id', $parentId)
            ->max('sort_order') ?? 0;

        Pages::create([
            'title'      => $request->title,
            'slug'       => $request->slug,
            'content'    => $request->content, // ✅ SIMPAN
            'meta_title' => $request->meta_title,
            'type'       => $request->type,
            'parent_id'  => $parentId,
            'active'     => 1,
            'sort_order' => $lastOrder + 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function parents()
    {
        return Pages::where('type', 'Pages')->get();
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
            'meta_title' => $request->meta_title,
            'type'       => $request->type,
            'parent_id'  => $request->parent_id,
            'active'     => $request->active ?? 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $page = Pages::findOrFail($id);
        $page->delete();
        return response()->json(['success' => true]);
    }

    public function orderUp($id)
    {
        DB::transaction(function () use ($id) {
            $page = Pages::findOrFail($id);

            // cari page di atasnya (order lebih kecil)
            $above = Pages::where('sort_order', '<', $page->sort_order)
                ->orderBy('sort_order', 'desc')
                ->first();

            // kalau tidak ada, berarti sudah paling atas
            if (!$above) {
                return;
            }

            // swap order
            $currentOrder = $page->sort_order;
            $page->sort_order = $above->sort_order;
            $above->sort_order = $currentOrder;

            $page->save();
            $above->save();
        });

        return response()->json(['success' => true]);
    }


    public function orderDown($id)
    {
        DB::transaction(function () use ($id) {
            $page = Pages::findOrFail($id);

            // cari page di bawahnya (order lebih besar)
            $below = Pages::where('sort_order', '>', $page->sort_order)
                ->orderBy('sort_order', 'asc')
                ->first();

            // kalau tidak ada, berarti sudah paling bawah
            if (!$below) {
                return;
            }

            // swap order
            $currentOrder = $page->sort_order;
            $page->sort_order = $below->sort_order;
            $below->sort_order = $currentOrder;

            $page->save();
            $below->save();
        });

        return response()->json(['success' => true]);
    }
}
