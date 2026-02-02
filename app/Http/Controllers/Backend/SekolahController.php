<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\Sekolah;
use Illuminate\Support\Str;

class SekolahController extends Controller
{
    public function index()
    {
        return view('sekolah');
    }

    public function data()
    {
        return Sekolah::orderBy('id', 'desc')->get();
    }

    public function store(Request $r)
    {
        Sekolah::create($r->all());
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return Sekolah::findOrFail($id);
    }

    public function update(Request $r, $id)
    {
        Sekolah::findOrFail($id)->update($r->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Sekolah::destroy($id);
        return response()->json(['success' => true]);
    }
}
