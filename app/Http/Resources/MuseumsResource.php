<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MuseumsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'typeId' => $this->typeId,
            'districtId' => $this->districtId,
            'Latitude' => $this->Latitude,
            'Longitude' => $this->Longitude
        ];
    }
}
