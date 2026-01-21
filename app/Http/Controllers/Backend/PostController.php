<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function index()
    {
        return view('backend.post');
    }

    public function data(Request $request)
    {
        $query = Post::with('kategori')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $query->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'konten'       => 'required',
            'kategori_id'  => 'required|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'gambar'       => 'nullable|string',
        ]);

        Post::create([
            'judul'           => $request->judul,
            'slug'            => Str::slug($request->judul),
            'konten'          => $request->konten,
            'kategori_id'     => $request->kategori_id,
            'user_id'         => Auth::id(),
            'status'          => $request->status,
            'tanggal_publish' => $request->status === 'published' ? now() : null,
            'gambar'          => $request->gambar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil disimpan'
        ]);
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'konten'       => 'required',
            'kategori_id'  => 'required|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'gambar' => 'nullable|string',
        ]);

        $post = Post::findOrFail($id);

        $post->judul           = $request->judul;
        $post->slug            = Str::slug($request->judul);
        $post->konten          = $request->konten;
        $post->kategori_id     = $request->kategori_id;
        $post->status          = $request->status;

        if ($request->filled('gambar')) {
            $post->gambar = $request->gambar;
        }

        if ($request->status === 'published' && $post->tanggal_publish === null) {
            $post->tanggal_publish = now();
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil diupdate'
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        return view('frontend.berita.show', compact('post'));
    }


    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus'
        ]);
    }
    
}
