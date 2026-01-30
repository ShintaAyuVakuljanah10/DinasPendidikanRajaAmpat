<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'jenjang' => 'required|in:SD/MI,SMP/MTS,PAUD/DIKMAS,SMA/SMK',
            'file'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|min:10|max:10240',
        ]);

        $uploaded = $request->file('file');
        $path = $uploaded->store('laporan', 'public');

        Download::create([
            'title'   => $request->title,
            'jenjang' => $request->jenjang,
            'file'    => $path,
            'page_id' => $request->page_id,
        ]);

        return back()->with('success', 'File berhasil diupload');
    }   

    public function destroy($id)
    {
        $download = Download::findOrFail($id);

        if (Storage::disk('public')->exists($download->file)) {
            Storage::disk('public')->delete($download->file);
        }

        $download->delete();

        return response()->json([
            'message' => 'File berhasil dihapus'
        ], 200);
    }
}
