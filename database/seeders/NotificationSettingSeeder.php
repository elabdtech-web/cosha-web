<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            NotificationSetting::create([
                'user_id' => $user->id,
                'general_notification' => true,
                'sound' => true,
                'vibrate' => true,
                'app_updates' => false,
                'promotion' => true,
                'discount_available' => false,
                'payment_request' => false,
                'push_notifications' => true,
                'new_tips_available' => true,
                'new_service_available' => false
            ]);
        }
    }
}
