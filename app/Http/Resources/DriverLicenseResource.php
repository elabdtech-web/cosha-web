<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class DriverLicenseResource extends JsonResource
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
            'name' => $this->name,
            'driver_id' => $this->driver_id,
            'license_no' => $this->license_no,
            'issued_date' => $this->issued_date,
            'expiry_date' => $this->expiry_date,
            'front_image' => $this->front_image ? Storage::url('drivers/' . $this->front_image) : null,
            'back_image' => $this->back_image ? Storage::url('drivers/' . $this->back_image) : null
        ];
    }
}
