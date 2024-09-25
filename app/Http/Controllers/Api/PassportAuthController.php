<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PassportAuthController extends Controller
{


    /**
     * Passenger registration
     */
    public function registerPassenger(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'gender' => 'required|string|in:male,female,other',
            'age' => 'required|string',
            'nic_no' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'statusCode' => 409,
                'message' => 'User already exists.',
            ], 409);
        }

        // Get passenger role from roles table
        $role = Role::where('name', 'passenger')->first();
        if (!$role) {
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'message' => 'Something went wrong.',
            ], 500);
        }


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($role); // For multiple roles
        $user->save();

        $tokenResult = $user->createToken('CoshaByElabdTechJWTAuthenticationToken');
        $accessToken = $tokenResult->accessToken;

        // Upload profile_image if exist
        if ($request->hasFile('profile_image')) {
            // Create unique name for profile_image
            $profile_image_name = Str::random(40) . '.' . $request->file('profile_image')->getClientOriginalExtension();
            // upload image to storage with unqie name
            $request->file('profile_image')->storeAs('public/profile_images', $profile_image_name);
            $profile_image_path = 'storage/profile_images/' . $profile_image_name;
        }

        // Create Passenger
        $passenger = Passenger::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'nic_no' => $request->nic_no,
            'profile_image' => $profile_image_name ?? null,
        ]);

        if (!$passenger) {
            // Delete user
            $user->delete();
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'message' => 'Something went wrong.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Passenger has been registered successfully.',
            'accessToken' => $accessToken,
            'data' => [
                'user_id' => $user->id,
            ],
        ], 200);
    }

    /**
     * Login User
     */
    public function loginPassenger(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if email exist

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'message' => 'Email does not exist.',
                'errors' => 'Unauthorized',
            ], 401);
        }

        // Check if user exists
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $user = $request->user();
            $tokenResult = $user->createToken('CoshaByElabdTechJWTAuthenticationToken');
            $accessToken = $tokenResult->accessToken;


            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Passenger has been logged successfully.',
                'accessToken' => $accessToken,
                'data' => [
                    'user_id' => $user->id,
                ],
            ], 200);

            // return $this->respondWithToken($token);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'message' => 'Invalid credentials.',
                'errors' => 'Invalid credentials.',
            ], 401);
        }
    }


    // Driver Auth APIs

    // Register Driver
    public function registerDriver(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'age' => 'required|integer',
            'preferred_passenger' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'statusCode' => 409,
                'message' => 'User already exists.',
            ], 409);
        }

        // Get driver role from roles table
        $role = Role::where('name', 'driver')->first();
        if (!$role) {
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'message' => 'Something went wrong.',
            ], 500);
        }


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Add role to user
        $user->roles()->attach($role); // For multiple roles
        $user->save();

        $tokenResult = $user->createToken('CoshaByElabdTechJWTAuthenticationToken');
        $accessToken = $tokenResult->accessToken;

        // Upload profile_image if exist
        if ($request->hasFile('profile_image')) {
            // Create unique name for profile_image
            $profile_image_name = Str::random(40) . '.' . $request->file('profile_image')->getClientOriginalExtension();
            // upload image to storage with unqie name
            $request->file('profile_image')->storeAs('public/drivers', $profile_image_name);
            $profile_image_path = 'storage/drivers/' . $profile_image_name;
        }

        // Create Driver
        $driver = Driver::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'age' => $request->age,
            'preferred_passenger' => $request->preferred_passenger,
            'profile_image' => $profile_image_name ?? null,
        ]);

        if (!$driver) {
            // Delete user
            $user->delete();
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'message' => 'Something went wrong.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Driver has been registered successfully.',
            'accessToken' => $accessToken,
            'data' => [
                'user_id' => $user->id,
            ],
        ], 200);
    }

    // driver login
    public function loginDriver(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if email exist
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'statusCode' => 401,
                'message' => 'Email does not exist.',
                'errors' => 'Unauthorized',
            ], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $tokenResult = $user->createToken('CoshaByElabdTechJWTAuthenticationToken');
            $accessToken = $tokenResult->accessToken;
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Driver has been logged in successfully.',
                'accessToken' => $accessToken,
                'data' => [
                    'user_id' => $user->id,
                ],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'statusCode' => 401,
            'message' => 'Unauthorized',
        ], 401);
    }
}
