<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverVehicleController extends Controller
{
    // Ger Driver Vehicle
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

        // driverVechicle
        $driverVechicle = DriverVehicle::where('driver_id', $driver->id)->first();
        if (!$driverVechicle) {
            return response()->json([
                'success' => false,
                'message' => 'Driver vehicle is not updated'
            ], 403);
        }

        // Check if vehicle_image is null
        if ($driverVechicle->vehicle_image) {
            $driverVechicle->vehicle_image = asset('storage/vehicle_images/' . $driverVechicle->vehicle_image);
        } else {
            $driverVechicle->vehicle_image = asset('images/default.png');
        }

        // Check if vehicle_document is null
        if ($driverVechicle->vehicle_document) {
            $driverVechicle->vehicle_document = asset('storage/vehicle_documents/' . $driverVechicle->vehicle_document);
        } else {
            $driverVechicle->vehicle_document = asset('images/default.png');
        }

        // Return Driver Vehicle

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver profile',
            'data' => $driverVechicle
        ]);
    }

    // updateVehicle
    public function updateVehicle(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'make' => 'required',
            'model' => 'required',
            'type' => 'required',
            'registration_no' => 'required',
            'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'vehicle_document' => 'nullable|mimes:pdf|max:10240',
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
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // Check if Driver has vehicle
        $driverVechicle = DriverVehicle::where('driver_id', $driver->id)->first();
        if (!$driverVechicle) {
            // Create one
            $driverVechicle = new DriverVehicle();
            $driverVechicle->driver_id = $driver->id;
        }

        $driverVechicle->make = $request->make;
        $driverVechicle->model = $request->model;
        $driverVechicle->type = $request->type;
        $driverVechicle->registration_no = $request->registration_no;

        // Check if vehicle_image has a value
        if ($request->hasFile('vehicle_image')) {
            $file = $request->file('vehicle_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('vehicle_images'), $filename);
            $driverVechicle->vehicle_image = $filename;
        }

        // Check if vehicle_document has a value
        if ($request->hasFile('vehicle_document')) {
            $file = $request->file('vehicle_document');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('vehicle_documents'), $filename);
            $driverVechicle->vehicle_document = $filename;
        }

        $driverVechicle->save();

        // Get vehicle_image path
        if ($driverVechicle->vehicle_image) {
            $driverVechicle->vehicle_image = Storage::url('vehicle_images/' . $driverVechicle->vehicle_image);
        }

        // Check if vehicle_document is null
        if ($driverVechicle->vehicle_document) {
            $driverVechicle->vehicle_document = Storage::url('vehicle_documents/' . $driverVechicle->vehicle_document);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver vehicle updated',
            'data' => $driverVechicle
        ]);
    }
}