<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class DriverIdentityDocuments extends JsonResource
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
            'driver_id' => $this->driver_id,
            'given_name' => $this->given_name,
            'surname' => $this->surname,
            'cnic_number' => $this->cnic_number,
            'expiry_date' => $this->expiry_date,
            'cnic_copy_front' => $this->cnic_copy_front ? Storage::url('images/drivers/' . $this->cnic_copy_front) : null,
            'cnic_copy_back' => $this->cnic_copy_back ? Storage::url('images/drivers/' . $this->cnic_copy_back) : null,
        ];
    }
}
