<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{

    // Ger profile
    public function index(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Driver Profile
        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // Add user email to driver

        $driver->email = $user->email;

        // Check if profile_image is null
        $driver->profile_image = asset('images/default.png');
        if ($driver->profile_image) {
            $driver->profile_image = asset('storage/profile_images' . $driver->profile_image);
        }

        // Return Driver

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver profile',
            'data' => $driver
        ]);
    }

    // updateProfile
    public function updateProfile(Request $request): JsonResponse
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate request

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'nic_no' => 'required',
            'license_no' => 'required',
            'preferred_passenger' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // Check if driver exist

        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            // Create one
            $driver = new Driver();
            $driver->user_id = $user->id;
        }

        // Update data as per request

        $driver->name = $request->name;
        $driver->phone = $request->phone;
        $driver->gender = $request->gender;
        $driver->age = $request->age;
        $driver->nic_no = $request->nic_no;
        $driver->license_no = $request->license_no;
        $driver->preferred_passenger = $request->preferred_passenger;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/profile_images directory
            $filePath = $file->storeAs('public/profile_images', $filename);
            $driver->profile_image = $filename;
        }

        $driver->save();

        // Get driver profile_image with url

        $driver->profile_image = $driver->profile_image ? Storage::url('profile_images/' . $driver->profile_image) : asset('images/default.png');

        // Return response

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Profile updated successfully.',
            'data' => $driver
        ], 200);
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
