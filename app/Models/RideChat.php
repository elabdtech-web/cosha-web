<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideChat extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'sender_id', 'receiver_id', 'ride_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    
}
