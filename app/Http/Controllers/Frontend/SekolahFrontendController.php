<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Pages;
use App\Models\BackEnd\Sekolah;
use Illuminate\Support\Facades\Storage;

class SekolahFrontendController extends Controller
{
    public function index($jenjang)
    {
        $page = Pages::where('slug', $jenjang)->firstOrFail();
        $mapJenjang = [
            'paudtkpkbm' => 'TK/KB/PKBM',
            'sdmi'       => 'SD/MI',
            'smpmts'     => 'SMP/MTS',
            'smasmk'     => 'SMA/SMK',
        ];

        if (!array_key_exists($jenjang, $mapJenjang)) {
            return redirect('/');
        }   

        $sekolah = Sekolah::where('jenjang', $mapJenjang[$jenjang])
            ->orderBy('nama_sekolah')
            ->get();

        return view('frontend.sekolah', [
            'page'        => $page,
            'sekolah'     => $sekolah,
            'jenjang'     => $jenjang,
            'judulHalaman'=> $mapJenjang[$jenjang],
        ]);
    }

    public function detail($id)
    {
        return Sekolah::findOrFail($id);
    }

}
