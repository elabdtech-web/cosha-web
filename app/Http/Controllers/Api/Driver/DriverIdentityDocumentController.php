<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
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

        // driverIdentityDocument
        $driverIdentityDocument = DriverIdentityDocument::where('driver_id', $driver->id)->first();
        if (!$driverIdentityDocument) {
            return response()->json([
                'success' => false,
                'message' => 'Driver identity document is not updated'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Driver identity document retrieved successfully',
            'data' => $driverIdentityDocument
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
            'document_number' => 'required',
            'issued_date' => 'required|date|before:expiry_date',
            'expiry_date' => 'required|date|after:issued_date',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
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
        $driverIdentityDocument->document_number = $request->document_number;
        $driverIdentityDocument->issued_date = $request->issued_date;
        $driverIdentityDocument->expiry_date = $request->expiry_date;

        // Front Image
        if ($request->hasFile('front_image')) {
            $file = $request->file('front_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('driver_identity_documents'), $filename);
            $driverIdentityDocument->front_image = $filename;
        }

        // Back Image
        if ($request->hasFile('back_image')) {
            $file = $request->file('back_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('driver_identity_documents'), $filename);
            $driverIdentityDocument->back_image = $filename;
        }

        $driverIdentityDocument->save();

        return response()->json([
            'success' => true,
            'message' => 'Driver identity document updated successfully',
            'data' => $driverIdentityDocument
        ], 200);
    }
}
