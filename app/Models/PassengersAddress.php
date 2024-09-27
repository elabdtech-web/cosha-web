<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengersAddress extends Model
{
    use HasFactory;
    protected $fillable = ['passenger_id', 'name', 'details', 'longitude', 'latitude'];

    protected $table = 'passengers_address';
}
