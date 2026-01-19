<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)
        ->orderBy('urutan', 'asc')
        ->get();

        return view('frontend.dashboard', compact('banners'));
    }
}
