<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ride;
use App\Models\User;
use App\Models\Passenger;
use App\RideStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver;

class HomeController extends Controller
{
    //index
    public function index()
    {
        // Statistics
        $data['total_passengers'] = Passenger::count();
        $data['total_drivers'] = Driver::count();
        $data['driver_requests'] = User::count();
        $data['completed_rides'] = Ride::where('status', RideStatus::COMPLETED->value)->count();
        $data['cancelled_rides'] = Ride::where('status', RideStatus::CANCELLED->value)->count();
        $data['ongoing_rides'] = Ride::where('status', RideStatus::STARTED->value)->count();

        // latest 5 drivers
        $latestDrivers = Driver::orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.index', compact('data', 'latestDrivers'));
    }
}
