<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PaymentMethodResource;
use App\Payments\Gateway;
use App\Models\User;

class PaymentMethodController extends Controller
{
/*     public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    } */

    public function index(Request $request)
    {
        return PaymentMethodResource::collection(
            $request->user()->paymentMethods()
        );
    }

    public function store(Request $request)
    {
        $user = User::first();
        $card = $this->gateway->withUser($user)
            ->createCustomer()
            ->addCard($request->token);

        return new PaymentMethodResource($card);
    }
}
