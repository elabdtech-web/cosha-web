<?php

namespace App\Http\Resources;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RideResource extends JsonResource
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
            'uuid' => $this->uuid,
            'type' => $this->type,
            'pickup_location' => $this->pickup_location,
            'dropoff_location' => $this->dropoff_location,
            'pickup_latitude' => (double) $this->pickup_latitude,
            'pickup_longitude' => (double) $this->pickup_longitude,
            'passenger_id' => $this->passenger_id,
            'no_passengers' => $this->no_passengers,
            'passenger_name' => Passenger::find($this->passenger_id)->name ?? null,
            'estimated_price' => (double) $this->estimated_price,
            'passenger_profile' => Passenger::find($this->passenger_id)->profile_image ?? null,
            'distance' => (double) $this->distance,
        ];
    }
}
