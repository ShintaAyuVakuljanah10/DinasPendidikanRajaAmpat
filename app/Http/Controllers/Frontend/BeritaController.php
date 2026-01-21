<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BeritaController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(12);

        return view('frontend.berita', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        return view('frontend.berita.show', compact('post'));
    }

}
