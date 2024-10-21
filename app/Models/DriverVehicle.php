<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'vehicle_name',
        'make',
        'model',
        'type',
        'registration_no',
        'vehicle_image',
        'vehicle_document',
        'capacity',
        'is_approved',
    ];

    /**
     * Get the driver that owns the vehicle.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
