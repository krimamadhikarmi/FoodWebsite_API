<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id'=>$this->id,
            'name'=> $this->name,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'created_at'=>$this->created_at,
        ];
    }
}
