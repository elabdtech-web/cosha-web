<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverIdentityDocuments;
use App\Models\Driver;
use App\Models\DriverIdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverIdentityDocumentController extends Controller
{
    // index
    public function index(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Driver Profile
        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        // driverIdentityDocument
        $driverIdentityDocument = DriverIdentityDocument::where('driver_id', $driver->id)->first();
        if (!$driverIdentityDocument) {
            return response()->json([
                'status' => false,
                'message' => 'Driver identity document is not updated'
            ], 403);
        }


        return response()->json([
            'status' => true,
            'message' => 'Driver identity document retrieved successfully',
            'data' => new DriverIdentityDocuments($driverIdentityDocument)
        ], 200);
    }

    // updateIdentity
    public function updateIdentity(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'given_name' => 'required',
            'surname' => 'required',
            'cnic_number' => 'required',
            'expiry_date' => 'required|date|after:issued_date',
            'cnic_copy_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'cnic_copy_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $driver = Driver::where('user_id', $user->id)->first();
        if (!$driver) {
            return response()->json([
                'message' => 'Driver profile is not updated'
            ], 403);
        }

        $driverIdentityDocument = DriverIdentityDocument::where('driver_id', $driver->id)->first();
        if (!$driverIdentityDocument) {
            //    Create one
            $driverIdentityDocument = new DriverIdentityDocument();
            $driverIdentityDocument->driver_id = $driver->id;
        }

        $driverIdentityDocument->given_name = $request->given_name;
        $driverIdentityDocument->surname = $request->surname;
        $driverIdentityDocument->cnic_number = $request->cnic_number;
        $driverIdentityDocument->expiry_date = $request->expiry_date;


        // CNIC Copy Front
        if ($request->hasFile('cnic_copy_front')) {
            $file = $request->file('cnic_copy_front');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/drivers directory
            $filePath = $file->storeAs('public/images/drivers', $filename);
            $driverIdentityDocument->cnic_copy_front = $filename;
        }

        // CNIC Copy Back
        if ($request->hasFile('cnic_copy_back')) {
            $file = $request->file('cnic_copy_back');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/drivers directory
            $filePath = $file->storeAs('public/images/drivers', $filename);
            $driverIdentityDocument->cnic_copy_back = $filename;
        }


        $driverIdentityDocument->save();

        return response()->json([
            'success' => true,
            'message' => 'Driver identity document updated successfully',
            'data' => new DriverIdentityDocuments($driverIdentityDocument)
        ], 200);
    }
}
