<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideDaily extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ride_daily';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time',
        'complete_time',
        'ride_id',
    ];

    /***
     * Get the ride associated with this daily ride.
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
