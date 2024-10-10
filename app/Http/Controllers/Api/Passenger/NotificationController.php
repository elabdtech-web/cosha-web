<?php

namespace App\Http\Controllers\Api\Passenger;

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
            $new_notifications = new NotificationSetting();
            $new_notifications->user_id = Auth::user()->id;
            $new_notifications->save();

            // Get new created notifications
            $notifications = NotificationSetting::where('user_id', Auth::user()->id)->first();
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
        $validated = $request->validate([
            'general_notification' => 'boolean',
            'sound' => 'boolean',
            'vibrate' => 'boolean',
            'app_updates' => 'boolean',
            'promotion' => 'boolean',
            'discount_available' => 'boolean',
            'payment_request' => 'boolean',
            'push_notifications' => 'boolean',
            'new_tips_available' => 'boolean',
            'new_service_available' => 'boolean'
        ]);

        // Update or create a notification setting for the user
        $notification = NotificationSetting::updateOrCreate(
            ['user_id' => Auth::user()->id],
            $validated
        );

        return response()->json([
            'status' => true,
            'message' => 'Notifications updated successfully',
            'data' => $notification
        ], 200);
    }
}
