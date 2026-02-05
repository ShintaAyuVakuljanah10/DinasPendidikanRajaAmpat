<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Banner;
use App\Models\Post;
use App\Models\Category;
use App\Models\BackEnd\Sekolah;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan', 'asc')
        ->get();

        $posts = Post::where('status', 'published')
            ->latest()
            ->limit(12)
            ->get();

        $categories = Category::orderBy('nama', 'asc')->get();

        $totalSekolah = Sekolah::count();
        $totalSiswa   = Sekolah::sum('jumlah_siswa');
        $totalGuru    = Sekolah::sum('jumlah_guru');

        return view('frontend.dashboard', 
        compact(
            'banners', 
            'posts', 
            'categories',
            'totalSekolah',
            'totalSiswa',
            'totalGuru'
        ));
    }
}
