<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passenger extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'gender',
        'age',
        'nic_no',
        'fcm_token',
        'language_code',
        'about_me',
        'interests',
        'ride_preference',
        'preferred_vehicle',
        'is_active',
        'is_deleted',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the passenger.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteDrivers()
    {
        return $this->belongsToMany(Driver::class, 'favorites');
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    // Other attributes and relationships

    public function sharedRides()
    {
        return $this->hasMany(SharedRide::class);
    }
}
