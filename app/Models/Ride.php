<?php

namespace App\Models;

use App\RideStatus;
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
        return $this->belongsTo(Passenger::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function rideDaily()
    {
        return $this->hasMany(RideDaily::class);
    }

    public function sharedRides()
    {
        return $this->hasMany(SharedRide::class);
    }


    // Define status

    public const STATUS_BADGES = [
        RideStatus::ACCEPTED->value => 'bg-success',
        RideStatus::CANCELLED->value => 'bg-danger',
        RideStatus::STARTED->value => 'bg-info',
        RideStatus::COMPLETED->value => 'bg-primary',
    ];

    // Method to get the badge class for the status
    public function getStatusBadge()
    {
        return self::STATUS_BADGES[$this->status] ?? 'bg-secondary'; // Default to 'badge-secondary' if status not found
    }
}
