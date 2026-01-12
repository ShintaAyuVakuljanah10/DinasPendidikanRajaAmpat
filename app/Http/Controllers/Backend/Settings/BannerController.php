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
    // public function update(Request $request)
    // {
    //     return redirect()->back()->with('success', 'Pengaturan banner disimpan');
    // }
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
            'gambar' => $request->gambar, // file-manager/xxx.jpg
            'urutan' => $urutan,
        ]);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $file = Banner::findOrFail($id);

        if (Storage::disk('public')->exists($file->gambar)) {
            Storage::disk('public')->delete($file->gambar);
        }

        $file->delete();

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

}
