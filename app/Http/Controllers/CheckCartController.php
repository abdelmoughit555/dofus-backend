<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CheckCartController extends Controller
{
    public function __invoke()
    {
        $products = request()->products;
        $notAvailable = [];
        $changed = false;

        foreach ($products as $key => $item) {
            $product = Product::where('name', $item["name"])->first();
            if(is_null($product)) {
                unset($products[$key]);
                array_push($notAvailable, $item);
                $changed = true;
            }

            if(!is_null($product) && $product->formattedPrice($product->price_sell) != $item["price"]) {
                $products[$key]['price'] = $product->formattedPrice($product->price_sell);
                $changed = true;
            }
        }

        return response()->json([
            'changed' => $changed,
            'notAvailable' => $notAvailable,
            'products' => $products
        ]);
    }

}
