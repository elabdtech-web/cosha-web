<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{

    // Ger profile
    public function index(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Check if user has role of driver

        // Driver Profile
        $driver = Driver::select('user_id', 'profile_image',  'name', 'phone', 'gender', 'age', 'preferred_passenger', 'language_code', 'is_active', 'is_deleted')->where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // Return Driver

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Passenger profile',
            'data' => $driver
        ]);
    }

    // logout
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
