<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Pages;

class DownloadController extends Controller
{
    public function index(Pages $page)
    {
        /**
         * $page:
         * - title
         * - slug
         * - content
         * - meta_title
         */

        return view('frontend.download', compact('page'));
    }
}
