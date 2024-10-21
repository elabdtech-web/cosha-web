<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::paginate(10);
        return view('admin.rides.index', compact('rides'));
    }

    public function show($ride)
    {
        $ride = Ride::find($ride);
        return view('admin.rides.view', compact('ride'));
    }
}
