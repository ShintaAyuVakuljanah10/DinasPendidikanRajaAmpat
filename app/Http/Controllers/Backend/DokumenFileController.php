<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BackEnd\File;

class DokumenFileController extends Controller
{
    public function index()
    {
        return view('backend.dokumenFile');
    }

    public function data()
    {
        return response()->json(File::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'file' => 'required|file|max:5120'
        ]);

        $path = $request->file('file')->store('dokumen','public');

        File::create([
            'nama'=>$request->nama,
            'file'=>$path
        ]);

        return response()->json(['success'=>true]);
    }

    public function edit($id)
    {
        return response()->json(File::findOrFail($id));
    }

    public function update(Request $request,$id)
    {
        $data = File::findOrFail($id);

        $request->validate([
            'nama'=>'required',
            'file'=>'nullable|file|max:5120'
        ]);

        $data->nama = $request->nama;

        if($request->hasFile('file')){

            if($data->file){
                Storage::disk('public')->delete($data->file);
            }

            $data->file = $request->file('file')->store('dokumen','public');
        }

        $data->save();

        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        $data = File::findOrFail($id);

        if($data->file){
            Storage::disk('public')->delete($data->file);
        }

        $data->delete();

        return response()->json(['success'=>true]);
    }
    public function front()
    {
        $files = File::latest()->get();

        return view('frontend.dokumenPublik', compact('files'));
    }
}

