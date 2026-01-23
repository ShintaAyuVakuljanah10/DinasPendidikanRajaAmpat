<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DokumenPublikController extends Controller
{
    public function index()
    {
        return view('frontend.dokumenPublik');
    }
}
