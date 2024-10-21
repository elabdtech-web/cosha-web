<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedRide extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'passenger_id',
        'join_km',
        'leave_km',
        'cost',
        'is_main_passenger',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',
    ];

    // Relationships
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }
}
