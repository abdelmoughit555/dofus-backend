<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->pivot->quantity,
            'image' => $this->image["url"],
            'type' => $this->pivot->type,
            'price' => $this->pivot->price
        ];
    }
}
