<?php

namespace App\Http\Resources;

use App\Models\DriverIdentityDocument;
use App\Models\DriverLicense;
use App\Models\DriverVehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class DriverProfileResource extends JsonResource
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
            'user_id' => auth()->user()->id,
            'name' => $this->name,
            'email' => auth()->user()->email,
            'phone' => $this->phone,
            'age' => $this->age,
            'profile_image' => $this->profile_image ? Storage::url('images/drivers/' . $this->profile_image) : null,
            'gender' => $this->gender,
            'preferred_passenger' => $this->preferred_passenger,
            'identity_document' => DriverIdentityDocument::where('driver_id', $this->id)->first() ? true : false,
            'vehicle' => DriverVehicle::where('driver_id', $this->id)->first() ? true : false,
            'license' => DriverLicense::where('driver_id', $this->id)->first() ? true : false,
        ];
    }
}
