<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverVehicleResource;
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


        // Return Driver Vehicle

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver Vehicle',
            'data' => new DriverVehicleResource($driverVechicle)
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
            'capacity' => 'required'
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

        $driverVechicle->vehicle_name = $request->vehicle_name;
        $driverVechicle->make = $request->make;
        $driverVechicle->model = $request->model;
        $driverVechicle->capacity = $request->capacity;
        $driverVechicle->type = $request->type;
        $driverVechicle->registration_no = $request->registration_no;

        // Check if vehicle_image has a value
        if ($request->hasFile('vehicle_image')) {
            $file = $request->file('vehicle_image');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/drivers directory
            $filePath = $file->storeAs('public/drivers', $filename);
            $driverVechicle->vehicle_image = $filename;
        }

        // Check if vehicle_document has a value
        if ($request->hasFile('vehicle_document')) {
            $file = $request->file('vehicle_document');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/drivers directory
            $filePath = $file->storeAs('public/drivers', $filename);
            $driverVechicle->vehicle_document = $filename;
        }

        $driverVechicle->save();

        // Get vehicle_image path
        if ($driverVechicle->vehicle_image) {
            $driverVechicle->vehicle_image = Storage::url('drivers/' . $driverVechicle->vehicle_image);
        }

        // Check if vehicle_document is null
        if ($driverVechicle->vehicle_document) {
            $driverVechicle->vehicle_document = Storage::url('drivers/' . $driverVechicle->vehicle_document);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver vehicle updated',
            'data' => $driverVechicle
        ]);
    }
}
