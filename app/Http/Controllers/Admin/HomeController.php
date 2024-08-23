<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Passenger;
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
        $data['completed_rides'] = 250;
        $data['cancelled_rides'] = 200;
        $data['ongoing_rides'] = 100;

        return view('admin.index', compact('data'));
    }
}
