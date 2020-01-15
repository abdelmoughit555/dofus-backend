<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'status' => $this->state,
            'currency' => $this->currency,
            'created' => $this->created_at->toDateTimeString(),
            'subtotal' => $this->subtotal,
            'products' => ProductOrderResource::collection(
                $this->whenLoaded('products')
            )
        ];
    }
}
