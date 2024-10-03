<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'driver_id',
        'offered_price',
        'status',
        'time',     // Add 'time'
        'distance'  // Add 'distance'
    ];

    // relations with drivers
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    // relations with rides
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id', 'id');
    }
}
