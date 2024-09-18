<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        return view('admin.rides.index');
    }

    public function show($ride)
    {
        return view('admin.rides.view');
    }
}
