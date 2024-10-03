<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;


    protected $fillable = [
        'uuid',
        'type',
        'pickup_location',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_location',
        'dropoff_latitude',
        'dropoff_longitude',
        'passenger_id',
        'estimated_price',
        'ride_price',
        'status',
        'no_passengers',
        'driver_id',
        'vehicle_name',
        'make',
        'model',
        'vehicle_type',
        'registration_no',
        'vehicle_image',
        'vehicle_document',
        'distance',
    ];

    // Define relationships
    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
