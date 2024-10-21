<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\Ride;
use App\RideStatus;
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

    public function show(Passenger $passenger)
    {
        $completedRides = Ride::where('passenger_id', $passenger->id)->where('status', RideStatus::COMPLETED->value)->get();
        // Cancel Rides
        $cancelRides = Ride::where('passenger_id', $passenger->id)->where('status', RideStatus::CANCELLED->value)->get();
        return view('admin.passengers.view', compact('passenger', 'completedRides', 'cancelRides'));
    }
}
