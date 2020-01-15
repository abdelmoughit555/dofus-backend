<?php

namespace App\Http\Resources;

class CartProductVariationResource extends ProductindexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'quantity' => $this->pivot->quantity,
            'type' => $this->pivot->type,
            'price' => number_format($this->pivot->price / 100, 2)
        ]);
    }
}
