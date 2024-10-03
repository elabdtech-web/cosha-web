<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\PassengersAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassengerAddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        $passenger = Passenger::where('user_id', $user->id)->first();
        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found',
                'data' => []
            ], 404);
        }
        // Fetch all addresses for the logged-in passenger
        $addresses = PassengersAddress::where('passenger_id', $passenger->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Addresses retrieved successfully',
            'data' => $addresses
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }
        $passenger = Passenger::where('user_id', $user->id)->first();
        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found',
                'data' => []
            ], 404);
        }

        $address = PassengersAddress::create([
            'passenger_id' => $passenger->id, // Get the ID of the authenticated passenger
            'name' => $request->name,
            'details' => $request->details,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Address created successfully',
            'data' => $address
        ], 200);
    }

    // specific address
    public function show($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        $passenger = Passenger::where('user_id', $user->id)
            ->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found',
                'data' => []
            ], 404);
        }
        $address = PassengersAddress::where('id', $id)
            ->where('passenger_id', $passenger->id)
            ->first();
        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Address retrieved successfully',
            'data' => $address
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
        ]);
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }
        $passenger = Passenger::where('user_id', $user->id)->first();
        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Passenger not found',
                'data' => []
            ], 404);
        }
        $address = PassengersAddress::where('id', $id)
            ->where('passenger_id', $passenger->id)
            ->first();
        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found',
                'data' => []
            ], 404);
        }
        $address->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully',
            'data' => $address
        ], 200);
    }
}
