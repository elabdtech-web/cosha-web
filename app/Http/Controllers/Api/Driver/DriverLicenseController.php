<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverLicense;
use App\Models\DriverVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverLicenseController extends Controller
{
    // Ger Driver License
    public function index(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Driver Profile
        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // driverLicense
        $driverLicense = DriverLicense::where('driver_id', $driver->id)->first();
        if (!$driverLicense) {
            return response()->json([
                'success' => false,
                'message' => 'Driver license is not updated'
            ], 403);
        }

        // Check if front_image is null
        if ($driverLicense->front_image) {
            $driverLicense->front_image = Storage::url('license_images' . $driverLicense->front_image);
        }

        // Check if back_image is null
        if ($driverLicense->back_image) {
            $driverLicense->back_image = Storage::url('license_images' . $driverLicense->back_image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Driver license retrieved successfully',
            'data' => $driverLicense
        ], 200);
    }

    // updateLicense
    public function updateLicense(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate request

        $validator = Validator::make($request->all(), [
            'license_no' => 'required',
            'name' => 'required',
            'issued_date' => 'required|date|before:expiry_date',
            'expiry_date' => 'required|date|after:issued_date',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        // Driver Profile
        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // driverLicense
        $driverLicense = DriverLicense::where('driver_id', $driver->id)->first();
        if (!$driverLicense) {
            // Create new driver license
            $driverLicense = new DriverLicense();
            $driverLicense->driver_id = $driver->id;
        }

        if ($request->hasFile('front_image')) {
            $file = $request->file('front_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('license_images'), $filename);
            $driverLicense->front_image = $filename;
        }

        if ($request->hasFile('back_image')) {
            $file = $request->file('back_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('license_images'), $filename);
            $driverLicense->back_image = $filename;
        }

        $driverLicense->license_no = $request->license_no;
        $driverLicense->name = $request->name;
        $driverLicense->issued_date = $request->issued_date;
        $driverLicense->expiry_date = $request->expiry_date;
        $driverLicense->save();

        // Check if front_image is null
        if ($driverLicense->front_image) {
            $driverLicense->front_image = Storage::url('license_images/' . $driverLicense->front_image);
        }

        // Check if back_image is null
        if ($driverLicense->back_image) {
            $driverLicense->back_image = Storage::url('license_images/' . $driverLicense->back_image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Driver license updated successfully',
            'data' => $driverLicense
        ], 200);
    }
}
