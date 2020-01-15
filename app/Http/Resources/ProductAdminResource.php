<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\ProductRequest;

class ProductAdminResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price_buy' => $this->price_buy,
            'price_sell' => $this->price_sell,
            'stock' => $this->stock,
            'is_sellable' => $this->is_sellable,
            'is_buyable' => $this->is_buyable,
            'category_id' => $this->categories[0]->id,
            'image' => $this->image["url"]
        ];
    }
}
