<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passenger;
use Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function favoriteDriver(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $user = Auth::user();

        $passenger = Passenger::where('user_id', $user->id)->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $driver = Driver::where('id', $request->driver_id)->first();

        if (!$driver) {
            return response([
                'status' => false,
                'message' => 'Driver not found',
            ], 404);
        }

        if (!$passenger->favoriteDrivers()->where('driver_id', $driver->id)->exists()) {
            $passenger->favoriteDrivers()->attach($driver->id);
            return response([
                'status' => true,
                'message' => 'Driver added to favorites',
            ], 200);
        }
        return response([
            'status' => false,
            'message' => 'Driver already added to favorites',
        ], 409);
    }

    public function unfavoriteDriver(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $user = Auth::user();

        $passenger = Passenger::where('user_id', $user->id)->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $driver = Driver::where('id', $request->driver_id)->first();

        if (!$driver) {
            return response([
                'status' => false,
                'message' => 'Driver not found',
            ], 404);
        }

        if ($passenger->favoriteDrivers()->where('driver_id', $driver->id)->exists()) {

            $passenger->favoriteDrivers()->detach($driver->id);

            return response([
                'status' => true,
                'message' => 'Driver removed from favorites',
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'Driver is not in your favorites',
        ], 404);
    }

    public function listFavoriteDrivers(Request $request)
    {
        $user = Auth::user();

        $passenger = Passenger::where('user_id', $user->id)->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $favoriteDrivers = $passenger->favoriteDrivers()->get();

        if ($favoriteDrivers->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'There is no driver found in your favorites',
                'data' => $favoriteDrivers
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Favorite Drivers',
            'data' => $favoriteDrivers
        ], 200);
    }

    public function favoriteDriverDetails(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        // Get the authenticated user
        $user = Auth::user();
        $passenger = Passenger::where('user_id', $user->id)->first();

        if (!$passenger) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Check if the driver is in favorite drivers list
        $favoriteDriver = $passenger->favoriteDrivers()->where('drivers.id', $request->driver_id)->first();

        if (!$favoriteDriver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver is not in your favorites',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Driver details retrieved successfully',
            'data' => $favoriteDriver
        ], 200);
    }
}
