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
            'status' => $this->status,
            'quantity' => $this->pivot->quantity,
            'image' => $this->name,
            'type' => $this->pivot->type,
            'price' => $this->pivot->price
        ];
    }
}
