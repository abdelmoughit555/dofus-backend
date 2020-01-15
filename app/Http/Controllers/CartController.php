<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        return (new CartResource($cart->ip()))
            ->additional([
                'meta' => [
                    'totalBuy' => number_format($cart->totalBuy() / 100, 2),
                    'totalSell' => number_format($cart->totalSell() / 100, 2),
                    'currency' => $cart->currency()
                ]
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart)
    {
        return $cart->add($request->product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        return $cart->update($request->products);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cart $cart)
    {
        return $cart->detach(request()->id, request()->type);
    }
}
