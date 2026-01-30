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
        // SLUG KHUSUS DOWNLOAD
        if (str_starts_with($slug, 'download-laporan-')) {
            return app(DownloadController::class)->index($slug);
        }

        // PAGE BIASA
        $page = Pages::where('slug', $slug)->firstOrFail();
        return view('frontend.page', compact('page'));
    }

    public function kategori(){
        return view('frontend.kategori');
    }
}
