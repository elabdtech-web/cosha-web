<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    //index
    public function index()
    {
        $passengers = Passenger::all();

        return view('admin.passengers.index', compact('passengers'));
    }

    // create
    public function create()
    {
        return view('admin.passengers.create');
    }
}
