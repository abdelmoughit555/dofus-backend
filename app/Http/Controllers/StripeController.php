<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Cart $cart)
    {
        $client = \Stripe\PaymentIntent::create([
            'amount' =>  round($cart->totalBuy('buy')),
            'currency' => $cart->currency() == 'EURO' ? 'eur' : 'mad'
        ]);

        return response()->json([
            'client' => $client,
            'user' => auth()->user()
        ]);
    }
}