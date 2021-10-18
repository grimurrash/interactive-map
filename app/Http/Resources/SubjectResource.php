<?php

namespace App\Http\Resources;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property double Latitude
 * @property double Longitude
 * @property string address
 * @property mixed createDate
 * @property string description
 * @property string founderFIO
 * @property int districtId
 * @property District district
 * @property int typeId
 * @property mixed type
 * @property string website
 * @property string video
 * @method videoUrl()
 */
class SubjectResource extends JsonResource
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
            'Latitude' => $this->Latitude,
            'Longitude' => $this->Longitude,
            'address' => $this->address,
            'createDate' => $this->createDate,
            'description' => $this->description,
            'founderFIO' => $this->founderFIO,
            'districtId' => $this->districtId,
            'districtName' => $this->district->name,
            'type' => [
                'id' => $this->typeId,
                'name' => $this->type->name,
                'color' => '#' . $this->type->color
            ],
            'website' => $this->website,
            'video' => $this->video
        ];
    }
}
