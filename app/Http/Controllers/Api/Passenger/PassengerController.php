<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
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

        // Check if user has role of passenger


        // Passenger Profile
        $passenger = Passenger::select('user_id', 'profile_image',  'name', 'phone', 'gender', 'age', 'nic_no', 'language_code', 'is_active', 'is_deleted')->where('user_id', $user->id)->first();
        if (!$passenger) {
            return response()->json([
                'message' => 'Passenger profile is not updated'
            ], 403);
        }

        // Return Passenger

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Passenger profile',
            'data' => $passenger
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
