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
        $passengers = Passenger::where('is_deleted', 0)->paginate(10);
        $title = '<span style="color: white">Delete Passenger!</span>';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.passengers.index', compact('passengers'));
    }

    // create
    public function create()
    {
        return view('admin.passengers.create');
    }

    public function show(Passenger $passenger)
    {
        $completedRides = Ride::where('passenger_id', $passenger->id)->where('status', RideStatus::COMPLETED->value)->paginate(5);
        // Cancel Rides
        $cancelRides = Ride::where('passenger_id', $passenger->id)->where('status', RideStatus::CANCELLED->value)->paginate(5);
        return view('admin.passengers.view', compact('passenger', 'completedRides', 'cancelRides'));
    }


    public function destroy(Passenger $passenger)
    {
        // is deleted
        $passenger->is_deleted = 1;
        $passenger->save();
        return redirect()->route('admin.passengers.index')->with('success', 'Passenger deleted successfully.');
    }
}
