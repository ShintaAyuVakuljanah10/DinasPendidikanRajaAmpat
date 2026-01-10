<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('backend.settings.banner');
    }
    public function update(Request $request)
    {
        return redirect()->back()->with('success', 'Pengaturan banner disimpan');
    }
}
