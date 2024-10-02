<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Http\Controllers\Controller;
use App\Http\Resources\PassengerResource;
use App\Models\Passenger;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        $passenger = Passenger::where('user_id', $user->id)->first();
        if (!$passenger) {
            return response()->json([
                'message' => 'Passenger profile is not updated'
            ], 403);
        }

        // Add user email to response
        $passenger->email = $user->email;

        // Check if profile_image is null
        if ($passenger->profile_image == null) {
            $passenger->profile_image = asset('images/default.png');
        }

        // Return Passenger

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Passenger profile',
            'data' => new PassengerResource($passenger)
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

        // Check if user has role of passenger
        if (!$user->hasRole('passenger')) {
            return response()->json([
                'message' => 'Unauthorized',
                'statusCode' => 403,
            ], 403);
        }

        // Validate request

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'nic_no' => 'required',
            'about_me' => 'required',
            'interests' => 'required',
            'ride_preference' => 'required',
            'preferred_vehicle' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'message' => $validator->errors()
            ], 400);
        }


        // Passenger Profile
        $passenger = Passenger::where('user_id', $user->id)->first();
        if (!$passenger) {
            // Create Passenger
            $passenger = new Passenger();
            $passenger->user_id = $user->id;
            $passenger->save();
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . rand(111, 999) . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/public/profile_images directory
            $filePath = $file->storeAs('public/profile_images', $filename);
            $passenger->profile_image = $filename;
        }

        // Update Passenger
        $passenger->name = $request->name;
        $passenger->gender = $request->gender;
        $passenger->phone = $request->phone;
        $passenger->age = $request->age;
        $passenger->nic_no = $request->nic_no;
        $passenger->about_me = $request->about_me;
        $passenger->interests = $request->interests;
        $passenger->ride_preference = $request->ride_preference;
        $passenger->preferred_vehicle = $request->preferred_vehicle;
        $passenger->save();

        // Return Passenger

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Passenger profile updated successfully',
            'data' => new PassengerResource($passenger)
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user(); // Get the currenty authenticated user

            if (!$user) {
                throw ValidationException::withMessages([
                    'message' => 'Unauthorized',
                ]);
            }

            //check if the current password if matches the stored one pass
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'The provided password does not match your current password.',
                ]);
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

        // Soft delete the passengers assionated with the user
        Passenger::where('user_id', $user->id)->update(['is_deleted' => 1, 'deleted_at' => now()]);

        $user->token()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Your account has been successfully deleted.',
        ], 200);
    }

    // Suggestions for Passenger

    public function suggestPassengers(Request $request)
    {
        // $request->validate([
        //     'latitude' => 'required',
        //     'longitude' => 'required|',
        // ]);

        // $userLatitude = $request->input('latitude');
        // $userLongitude = $request->input('longitude');

        // // Find passengers nearby within 5 km
        // $suggestions = DB::table('passengers_address')
        //     ->select('passenger_id', 'name', 'details', 'latitude', 'longitude')
        //     ->havingRaw("
        //     (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))
        //     < 5
        // ", [$userLatitude, $userLongitude, $userLatitude])
        //     ->limit(10) // Limit to 10 suggestions
        //     ->get();

        $suggestions = DB::table('passengers')
            ->where('deleted_at', null)
            ->limit(10) // Limit to 10 suggestions
            ->get();


        return response()->json([
            'success' => true,
            'message' => 'Suggestions fetched successfully.',
            'data' => PassengerResource::collection($suggestions),
        ], 200);
    }

    // search passengers

    public function search(Request $request)
    {
        // Build the query
        $query = Passenger::query()
            ->where('deleted_at', null);

        // Apply filters based on request

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        $passengers = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Passengers fetched successfully.',
            'data' => PassengerResource::collection($passengers),
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
