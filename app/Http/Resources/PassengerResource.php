<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PassengerResource extends JsonResource
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
            'email' => User::find($this->user_id)->email,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'age' => $this->age,
            'nic_no' => $this->nic_no,
            'profile_image' => Storage::url('profile_images/' . $this->profile_image),
            'about' => $this->about,
            'ride_preference' => $this->ride_preference,
            'prefred_vehicle' => $this->prefred_vehicle
        ];
    }
}
