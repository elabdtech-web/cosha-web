<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLicense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'license_no',
        'name',
        'issued_date',
        'expiry_date',
        'front_image',
        'back_image',
        'is_approved',
    ];

    /**
     * Get the driver that owns the license.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
