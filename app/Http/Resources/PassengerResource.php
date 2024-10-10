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
            'email' => User::find($this->user_id)->email ?? null,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'age' => $this->age,
            'nic_no' => $this->nic_no,
            'profile_image' => $this->profile_image ? Storage::url('profile_images/' . $this->profile_image) : Storage::url('default.png'),
            'about_me' => $this->about_me,
            'ride_preference' => $this->ride_preference,
            'preferred_vehicle' => $this->preferred_vehicle
        ];
    }
}
