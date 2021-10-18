<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property int typeId
 * @property string name
 * @property int districtId
 * @property double Latitude
 * @property double Longitude
 * @property mixed type
 */
class SubjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'typeId' => $this->typeId,
            'typeColor' => '#' . $this->type->color,
            'districtId' => $this->districtId,
            'Latitude' => $this->Latitude,
            'Longitude' => $this->Longitude
        ];
    }
}
