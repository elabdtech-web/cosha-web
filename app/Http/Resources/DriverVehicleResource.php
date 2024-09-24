<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class DriverVehicleResource extends JsonResource
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
            'type' => $this->type,
            'vehicle_name' => $this->vehicle_name,
            'make' => $this->make,
            'model' => $this->model,
            'registration_no' => $this->registration_no,
            'vehicle_image' => $this->vehicle_image ? Storage::url('drivers/' . $this->vehicle_image) : null,
            'vehicle_document' => $this->vehicle_document ? Storage::url('drivers/' . $this->vehicle_document) : null
        ];
    }
}
