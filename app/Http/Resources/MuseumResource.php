<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed name
 * @property mixed Latitude
 * @property mixed Longitude
 * @property mixed address
 * @property mixed createDate
 * @property mixed description
 * @property mixed directorFio
 * @property mixed directorEmail
 * @property mixed directorPhone
 * @property mixed email
 * @property mixed founderFIO
 * @property mixed location
 * @property mixed districtId
 * @property mixed district
 * @property mixed phone
 * @property mixed typeId
 * @property mixed museumType
 * @property mixed website
 */
class MuseumResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'Latitude' => $this->Latitude,
            'Longitude' => $this->Longitude,
            'address' => $this->address,
            'createDate' => $this->createDate,
            'description' => $this->description,
            'director' => [
                'fio' => $this->directorFio,
                'email' => $this->directorEmail,
                'phone' => $this->directorPhone,
            ],
            'email' => $this->email,
            'founderFIO' => $this->founderFIO,
            'location' => $this->location,
            'districtId' => $this->districtId,
            'districtName' => $this->district->name,
            'phone' => $this->phone,
            'type' => [
                'id' => $this->typeId,
                'name' => $this->museumType->name
            ],
            'website' => $this->website
        ];
    }
}
