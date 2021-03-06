<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminMuseumsResource extends JsonResource
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
            'name' =>$this->name,
            'code'=>$this->code,
            'type'=>$this->museumType->name,
            'district'=>$this->district->name,
            'description' =>$this->description
        ];
    }
}
