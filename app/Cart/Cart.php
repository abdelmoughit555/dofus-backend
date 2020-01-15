<?php

namespace App\Cart;

use App\Models\Product;

class Cart
{
    private $ip;
    private $currentQuantity = false;

    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function ip()
    {
        return $this->ip;
    }

    public function currency()
    {
        return $this->ip->currency;
    }

    public function products($type)
    {
        return $this->ip->products->where('pivot.type', $type);
    }

    public function add($product)
    {
        $this->currentQuantity = true;

        $product = $this->product($product);

        return  $this->ip->products()->wherePivot('type', $product["type"])
            ->syncWithoutDetaching([
                $product["id"] =>
                [
                    'quantity' => $product["quantity"],
                    'type' => $product["type"],
                    'price' => $product["price"],
                ]
            ]);
    }

    public function totalBuy()
    {
        return $this->total('buy');
    }

    public function totalSell()
    {
        return $this->total('sell');
    }

    private function total($type)
    {
        return $this->ip->products->sum(function ($product) use ($type) {
            if ($product->pivot->type == $type) {
                return  $product->pivot->price;
            }
        });
    }


    public function update($products)
    {
        $products = collect($products)->each(function ($product) {
            $product = $this->product($product);

            $this->ip->products()->where('products.id', $product["id"])
                ->wherePivot('type', $product["type"])
                ->update([
                    'quantity' => $product["quantity"],
                    'price' => $product["price"],
                ]);
        });

        return $products;
    }

    public function destroy($type)
    {
        $this->ip->products()->wherePivot('type', $type)->detach();
    }

    public function detach($id, $type)
    {
        $this->ip->products()
            ->wherePivot('type', $type)
            ->detach($id);
    }

    protected function product($product)
    {
        $productInstance = Product::find($product['id']);
        $priceType = $product["type"] == 'buy' ? $productInstance->price_buy : $productInstance->price_sell;
        $rate = $this->ip->currency == 'MAD' ? 1 : config('services.stripe.euro');
        $quantity = $product["quantity"] + $this->getCurrentQuantity($productInstance->id, $product["type"]);
        $price = ($priceType / $rate) * $quantity;

        return [
            'id' => $productInstance->id,
            'price' => $price,
            'quantity' => $quantity,
            'type' => $product["type"]
        ];
    }

    protected function getCurrentQuantity($productId, $type)
    {
        if ($this->currentQuantity && $product = $this->ip->products()->wherePivot('type', $type)->where('products.id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}
