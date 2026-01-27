<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\Pages;

class FrontEndController extends Controller
{
    public function index()
    {
        $pages = Pages::whereNull('parent_id')
            ->where('active', 1)
            ->orderBy('sort_order', 'asc')
            ->with('children')
            ->get();

        return view('frontend.navbar', compact('pages'));   
    }

    public function show($slug)
    {
        $page = Pages::where('slug', $slug)
            ->where('active', 1)
            ->firstOrFail();

        if ($page->handler === 'download') {
            return app(DownloadController::class)->index($page);
        }

        return view('frontend.page', compact('page'));
    }

    public function kategori(){
        return view('frontend.kategori');
    }
}
