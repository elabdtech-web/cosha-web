<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverIdentityDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'given_name',
        'surname',
        'father_name',
        'cnic_copy_front',
        'cnic_copy_back',
        'cnic_number',
        'document_number',
        'issued_date',
        'expiry_date',
        'front_image',
        'back_image',
        'is_approved',
    ];

    /**
     * Get the driver that owns the identity document.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
