<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'tagline'=>$this->tagline,
            'weight'=>$this->weight,
            'price'=>$this->price,
            'ingridents'=>$this->ingridents,
            'description'=>$this->description,
            'created_at'=>$this->created_at,
        ];
    }
}
