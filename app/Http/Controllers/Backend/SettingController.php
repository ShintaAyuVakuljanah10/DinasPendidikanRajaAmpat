<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function aplikasi()
    {
        return view('backend.settings.aplikasi');
    }

    public function banner()
    {
        return view('backend.settings.banner');
    }
}
