<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductIndexResource;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $buy = request()->buy === 'true' ? true : false;

        return $buy ? $this->buyable($request) : $this->sellable($request);
    }

    protected function  sellable($request)
    {
        return array_merge(parent::toArray($request), [
            'price' => number_format(($this->price_sell / 100) / $this->rate(),2),
            'is_sellable' => $this->is_sellable,
        ]);
    }

    protected function buyable($request)
    {
        return array_merge(parent::toArray($request), [
            'price' => number_format(($this->price_buy / 100) / $this->rate(),2),
            'is_buyable' => $this->is_buyable,
        ]);
    }
}
