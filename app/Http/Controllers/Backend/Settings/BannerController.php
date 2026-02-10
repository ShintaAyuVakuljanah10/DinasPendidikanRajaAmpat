<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        return view('backend.settings.banner');
    }
    public function data()
    {
        return response()->json(
            Banner::orderBy('urutan')->get()
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required',
            'gambar' => 'required|string',
        ]);

        $urutan = Banner::max('urutan') + 1;

        Banner::create([
            'nama'   => $request->nama,
            'gambar' => $request->gambar,
            'urutan' => $urutan,
        ]);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $banner->delete();

        return response()->json(['success' => true]);
    }
    public function up($id)
    {
        $banner = Banner::findOrFail($id);

        $atas = Banner::where('urutan', '<', $banner->urutan)
            ->orderBy('urutan', 'desc')
            ->first();

        if ($atas) {
            [$banner->urutan, $atas->urutan] = [$atas->urutan, $banner->urutan];
            $banner->save();
            $atas->save();
        }
    }

    public function down($id)
    {
        $banner = Banner::findOrFail($id);

        $bawah = Banner::where('urutan', '>', $banner->urutan)
            ->orderBy('urutan', 'asc')
            ->first();

        if ($bawah) {
            [$banner->urutan, $bawah->urutan] = [$bawah->urutan, $banner->urutan];
            $banner->save();
            $bawah->save();
        }
    }
    public function edit($id)
    {
        return response()->json(
            Banner::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'   => 'required',
            'gambar' => 'required|string',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->update([
            'nama'   => $request->nama,
            'gambar' => $request->gambar,
        ]);

        return response()->json(['success' => true]);
    }


}
