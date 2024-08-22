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
        'is_active',
        'is_deleted',
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
}
