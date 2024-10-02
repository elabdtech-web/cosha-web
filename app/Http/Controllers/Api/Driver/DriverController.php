<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverProfileResource;
use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

        // // Check if profile_image is null
        // $driver->profile_image = asset('images/default.png');
        // if ($driver->profile_image) {
        //     $driver->profile_image = asset('storage/images/drivers/' . $driver->profile_image);
        // }

        // Return Driver

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver profile',
            'data' => new DriverProfileResource($driver)
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
        $driver->preferred_passenger = $request->preferred_passenger;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/profile_images directory
            $filePath = $file->storeAs('public/images/drivers', $filename);
            $driver->profile_image = $filename;
        }

        $driver->save();

        // Get driver profile_image with url

        $driver->profile_image = $driver->profile_image ? Storage::url('images/drivers/' . $driver->profile_image) : asset('images/default.png');

        // Return response

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Profile updated successfully.',
            'data' => $driver
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currenty authenticated user

            if (!$user) {
                throw ValidationException::withMessages([
                    'message' => ['Unauthorized'],
                ]);
            }
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            //check if the current password if matches the stored one pass
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The provided password does not match your current password.',
                ], 422);
            }

            // Update the Password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully',
            ], 200);

        } catch (ValidationException $e) {
            // If validation fails, return error response
            return response()->json([
                'status' => false,
                'error' => $e->errors(),
            ], 422); // 422 Unprocessable Entity for validation errors
        }
    }

    public function sofDeleteAcount()
    {
        // Get current authenticated user
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        // Soft delete associations with passengers
        Driver::where('user_id', $user->id)->update(['is_deleted' => 1, 'deleted_at' => now()]);

        $user->token()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Your account has been successfully deleted .',
        ], 200);
    }

    // logout
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
