<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'gender',
        'age',
        'preferred_passenger',
        'profile_image',
        'fcm_token',
        'language_code',
        'is_active',
        'is_deleted',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the driver.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasOne(DriverVehicle::class);
    }

    // 'identity_document', 'license'
    public function identity_document()
    {
        return $this->hasOne(DriverIdentityDocument::class);
    }

    public function license()
    {
        return $this->hasOne(DriverLicense::class);
    }

    public function favoritedByPassengers()
    {
        return $this->belongsToMany(Passenger::class, 'favorites');
    }

}
