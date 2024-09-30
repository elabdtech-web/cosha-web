<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Http\Resources\PassengerResource;
use App\Models\Friend;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    public function addFriend(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user(); // The currently authenticated user
        $friend_id = $request->input('friend_id');

        // Check if both users are passengers
        $isCurrentUserPassenger = Passenger::where('user_id', $user->id)
            ->where('deleted_at', null)
            ->exists();

        if (!$isCurrentUserPassenger) {
            return response()->json(['status' => false, 'message' => 'You must be a passenger to add friends.'], 403);
        }

        // Check if the friend being added is also a passenger and not soft deleted
        $isFriendPassenger = Passenger::where('user_id', $friend_id)
            ->where('deleted_at', null) // Ensure the friend is not soft deleted
            ->exists();

        if (!$isFriendPassenger) {
            return response()->json([
                'status' => false,
                'message' => 'You can only add other active passengers as friends.'
            ], 403);
        }

        // Check if they are already friends
        $alreadyFriends = $user->friends()->where('friend_id', $friend_id)->exists();

        if ($alreadyFriends) {
            return response()->json(['status' => false, 'message' => 'You are already friends.'], 400);
        }

        // Add the friend
        $user->friends()->attach($friend_id); // Using the attach method

        return response()->json(['status' => true, 'message' => 'Friend added successfully'], 200);
    }


    public function getFriends()
    {
        $user = auth()->user(); // The currently authenticated user
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }
        $friends = Friend::where('user_id', $user->id)->get();

        if (!$friends) {
            return response()->json(['status' => false, 'message' => 'No friends found.'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Friends retrieved successfully',
            'data' => FriendResource::collection($friends),
        ]);
    }

    public function removeFriend(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user(); // The currently authenticated user
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $friend_id = $request->input('friend_id');

        if (!$friend_id) {
            return response()->json(['status' => false, 'message' => 'Friend not found.'], 404);
        }

        // Check if the friend is actually a friend of the user

        $isFriend = $user->friends()->where('friend_id', $friend_id)->exists();

        if (!$isFriend) {
            return response()->json(['status' => false, 'message' => 'This user is not your friend.'], 404);
        }

        // Remove the friend relationship

        $user->friends()->detach($friend_id);  // Using the detach method

        return response()->json(['status' => true, 'message' => 'Friend removed successfully'], 200);
    }

    public function friendDetails(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user(); // The currently authenticated user
        $friend_id = $request->input('friend_id');

        // Check if the specified user is actually a friend
        $isFriend = $user->friends()->where('friend_id', $friend_id)->exists();

        if (!$isFriend) {
            return response()->json(['status' => false, 'message' => 'This user is not your friend.'], 400);
        }

        // Get friend details with passenger relationship
        $friend = Friend::where('friend_id', $friend_id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Friend details retrieved successfully',
            'data' => new FriendResource($friend),
        ]);
    }
}
