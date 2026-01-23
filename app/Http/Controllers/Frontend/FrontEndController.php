<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackEnd\Pages;

class FrontEndController extends Controller
{
    public function index()
    {
        $pages = Pages::whereNull('parent_id')
            ->where('active', 1)
            ->orderBy('sort_order', 'asc')
            ->with('children')
            ->get();

        return view('frontend.navbar', compact('pages'));   
    }
}
