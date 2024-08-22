<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // index
    public function index()
    {
        return view('frontend.index');
    }
}
