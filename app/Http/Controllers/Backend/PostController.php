<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // 🔹 tampil halaman
    public function index()
    {
        return view('backend.post');
    }

    // 🔹 ambil data (AJAX)
    public function data()
    {
        $posts = Post::latest()->get();
        return response()->json($posts);
    }

    // 🔹 simpan data
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->author = $request->author;
        $post->intro = $request->intro;
        $post->content = $request->content;
        $post->category = $request->category;
        $post->label = $request->label;
        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->status = $request->status;
        $post->published_at = $request->published_at;
        $post->created_by = auth()->id();

        // upload image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $name);
            $post->image = $name;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil disimpan'
        ]);
    }

    // 🔹 edit (ambil 1 data)
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    // 🔹 update
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->author = $request->author;
        $post->intro = $request->intro;
        $post->content = $request->content;
        $post->category = $request->category;
        $post->label = $request->label;
        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->status = $request->status;
        $post->published_at = $request->published_at;
        $post->updated_by = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $name);
            $post->image = $name;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil diupdate'
        ]);
    }

    // 🔹 hapus
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus'
        ]);
    }
}
