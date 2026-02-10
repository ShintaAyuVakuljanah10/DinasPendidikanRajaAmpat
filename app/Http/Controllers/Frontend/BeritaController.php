<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Backend\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(12);
        $categories = Category::orderBy('nama', 'asc')->get();
        return view('frontend.berita', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        $categories = Category::withCount('posts')->get();

        return view('frontend.detailBerita', compact('post', 'categories'));
    }
    public function kategori($slug)
    {
        $kategori = Category::where('slug', $slug)->firstOrFail();

        $beritas = Berita::where('kategori_id', $kategori->id)
                        ->latest()
                        ->paginate(12);

        return view('frontend.kategori', compact('kategori', 'beritas'));
    }

}
