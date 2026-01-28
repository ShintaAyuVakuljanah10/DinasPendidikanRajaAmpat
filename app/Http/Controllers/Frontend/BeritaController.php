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

        return view('frontend.berita', compact('posts'));
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
        // Ambil kategori
        $kategori = Category::where('slug', $slug)->firstOrFail();

        // Ambil berita sesuai kategori
        $beritas = Berita::where('kategori_id', $kategori->id)
                        ->latest()
                        ->paginate(12); // Pagination

        return view('frontend.kategori', compact('kategori', 'beritas'));
    }

}
