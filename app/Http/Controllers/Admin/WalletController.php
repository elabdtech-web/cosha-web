<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        return view('admin.wallets.index');
    }

    public function create()
    {
        return view('admin.wallets.create');
    }
}
