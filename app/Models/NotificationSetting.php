<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'general_notification',
        'sound',
        'vibrate',
        'app_updates',
        'promotion',
        'discount_available',
        'payment_request',
        'push_notifications',
        'new_tips_available',
        'new_service_available'
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
