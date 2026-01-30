<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Pages;
use App\Models\BackEnd\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index($slug)
    {
        $page = Pages::where('slug', $slug)->firstOrFail();
    
        // ambil kode jenjang dari slug
        if (str_contains($slug, 'sd')) {
            $jenjang = 'SD/MI';
        } elseif (str_contains($slug, 'smp')) {
            $jenjang = 'SMP/MTS';
        } elseif (str_contains($slug, 'paud')) {
            $jenjang = 'PAUD/DIKMAS';
        } elseif (str_contains($slug, 'sma')) {
            $jenjang = 'SMA/SMK';
        } else {
            $jenjang = null;
        }
    
        $downloads = Download::where('jenjang', $jenjang)
            ->latest()
            ->get();
    
        return view('frontend.download', compact('page', 'downloads', 'jenjang'));
    }    
        
    public function download($id)
    {
        $file = Download::findOrFail($id);

        $path = storage_path('app/public/' . $file->file);

        // bersihin judul biar aman jadi nama file
        $safeName = str_replace(['/', '\\'], '-', $file->title);

        $extension = pathinfo($file->file, PATHINFO_EXTENSION);

        $fileName = $safeName . '.' . $extension;

        return response()->download($path, $fileName);
    }
}

