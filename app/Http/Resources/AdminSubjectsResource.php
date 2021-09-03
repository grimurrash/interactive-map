<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\SubjectType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string name
 * @property SubjectType type
 * @property District district
 * @property string description
 */
class AdminSubjectsResource extends JsonResource
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
            'name' =>$this->name,
//            'type'=>$this->type->name,
            'district'=>$this->district->name,
            'description' =>$this->description
        ];
    }
}
