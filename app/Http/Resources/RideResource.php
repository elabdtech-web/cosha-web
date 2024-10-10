<?php

namespace App\Http\Resources;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'pickup_latitude' => (float) $this->pickup_latitude,
            'pickup_longitude' => (float) $this->pickup_longitude,
            'passenger_id' => $this->passenger_id,
            'no_passengers' => $this->no_passengers,
            'passenger_name' => Passenger::find($this->passenger_id)->name ?? null,
            'estimated_price' => (float) $this->estimated_price,
            'passenger_profile' => Passenger::find($this->passenger_id)->profile_image ? Storage::url('profile_images/' . Passenger::find($this->passenger_id)->profile_image) : Storage::url('default.png'),
            'distance' => (float) $this->distance,
        ];
    }
}
