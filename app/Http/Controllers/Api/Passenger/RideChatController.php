<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Events\ChatEvent;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\RideChat;
use Auth;
use Illuminate\Http\Request;

class RideChatController extends Controller
{
    public function getChats($id)
    {
        $ride = Ride::find($id);

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found.',
            ], 404);
        }

        // get passenger
        $passenger = $ride->passenger;

        $messages = RideChat::where('booking_id', $ride->id)
            ->with('sender', 'receiver')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Chats retrieved successfully.',
            'data' => $messages,
            'passenger' => $passenger
        ], 200);

    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'message' => 'required',
        ]);

        $ride = Ride::find($request->ride_id);

        if (!$ride) {
            return response()->json([
                'status' => false,
                'message' => 'Ride not found.',
            ], 404);
        }

        $sender_id = Auth::user()->id;
        $receiver_id = $ride->driver->user_id;

        $chatMessage = new RideChat();
        $chatMessage->ride_id = $ride->id;
        $chatMessage->sender_id = $sender_id;
        $chatMessage->receiver_id = $receiver_id;
        $chatMessage->message = $request->message;
        $chatMessage->save();

        MessageSent::dispatch($chatMessage->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully.',
            'data' => $chatMessage
        ], 200);
    }
}
