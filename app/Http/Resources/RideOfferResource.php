<?php

namespace App\Http\Resources;

use App\Models\Driver;
use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RideOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'distance' => (double) $this->distance ?? 0.0,
            'ride_type' => Ride::find($this->ride_id)->type,
            'ride_id' => $this->ride_id,
            'pickup_location' => Ride::find($this->ride_id)->pickup_location,
            'dropoff_location' => Ride::find($this->ride_id)->dropoff_location,
            'time' => $this->time ?? null,
            'driver_id' => $this->driver_id,
            'name' => Driver::find($this->driver_id)->name ?? null,
            'offered_price' => (double) $this->offered_price,
            'status' => $this->status,
            'vehicle_name' => Driver::find($this->driver_id)->vehicles->vehicle_name ?? null,
            'profile' => Storage::url('profile_images/' . Driver::find($this->driver_id)->profile_image ?? '') ?? null,
            'no_passengers' => Ride::find($this->ride_id)->no_passengers,
            'vehicle_image' => ''
        ];
    }
}
