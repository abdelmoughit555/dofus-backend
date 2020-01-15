<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IPResource extends JsonResource
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
            'ip' => $this->ip,
            'currency' => $this->currency,
            'country' => $this->country
        ];
    }
}