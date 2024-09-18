<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    public function index()
    {
        return view('admin.rewards.index');
    }

    public function create()
    {
        return view('admin.rewards.create');
    }
}
