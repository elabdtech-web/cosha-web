<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = NotificationSetting::where('user_id', Auth::user()->id)->first();

        if (!$notifications) {
            $notifications = new NotificationSetting();
            $notifications->user_id = Auth::user()->id;
            $notifications->save();
            return response()->json([
                'status' => true,
                'message' => 'Notifications retrieved successfully',
                'data' => $notifications
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Notifications retrieved successfully',
            'data' => $notifications
        ], 200);
    }

    // update the notifications for specific user
    public function updateNotifications(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Validate request data
        $validated = $request->validate([
            'general_notification' => 'boolean|nullable',
            'sound' => 'boolean|nullable',
            'vibrate' => 'boolean|nullable',
            'app_updates' => 'boolean|nullable',
            'promotion' => 'boolean|nullable',
            'discount_available' => 'boolean|nullable',
            'payment_request' => 'boolean|nullable',
            'push_notifications' => 'boolean|nullable',
            'new_tips_available' => 'boolean|nullable',
            'new_service_available' => 'boolean|nullable',
        ]);

        // Update or create a notification setting for the authenticated user
        $notification = NotificationSetting::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return response()->json([
            'status' => true,
            'message' => 'Notifications updated successfully',
            'data' => $notification
        ], 200);
    }
}
