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

    public function data()
    {
        $posts = Post::with(['kategori', 'user'])
            ->latest()
            ->get();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'konten'       => 'required',
            'kategori_id'  => 'required|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $post = new Post();
        $post->judul           = $request->judul;
        $post->slug            = Str::slug($request->judul);
        $post->konten          = $request->konten;
        $post->kategori_id     = $request->kategori_id;
        $post->user_id         = Auth::id();
        $post->status          = $request->status;
        $post->tanggal_publish = $request->status === 'published'
                                    ? now()
                                    : null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $name);
            $post->gambar = $name;
        }

        $post->save();

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
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $post = Post::findOrFail($id);

        $post->judul           = $request->judul;
        $post->slug            = Str::slug($request->judul);
        $post->konten          = $request->konten;
        $post->kategori_id     = $request->kategori_id;
        $post->status          = $request->status;

        if ($request->status === 'published' && $post->tanggal_publish === null) {
            $post->tanggal_publish = now();
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $name);
            $post->gambar = $name;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil diupdate'
        ]);
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
