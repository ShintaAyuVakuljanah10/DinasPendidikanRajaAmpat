<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Banner;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan', 'asc')
        ->get();

        $posts = Post::where('status', 'published')
            ->latest()
            ->limit(12)
            ->get();


        return view('frontend.dashboard', compact('banners', 'posts'));
    }
}
