<?php

namespace App\Payments\Services;

use App\Exceptions\PaymenetFialedException;
use App\Payments\Gateway;
use Stripe\Charge as StripeCharge;
use Stripe\Customer as StripeCustomer;
use Exception;

class StripePayment implements Gateway
{
    public function charge($order)
    {
        try {
            $card = $this->checkCustomer($order);

            StripeCharge::create([
                'currency' => 'gbp',
                'amount' => "1000",
                'customer' => $card["customer"]->id,
                'source' => $card["card"]->id
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function retrieveCustomer($id)
    {
        return StripeCustomer::retrieve($id);
    }

    protected function createCustomer($order)
    {
        $customer = StripeCustomer::create([
            'email' => auth()->user()->email
        ]);

        return $customer;
    }


    protected function checkCustomer($order)
    {
        $id = $order->user->gateway_customer_id;

        $customer = !is_null($id) ? $this->retrieveCustomer($id) : $this->createCustomer(auth()->user()->email);

        $card = $customer->sources->create([
            'source' => request()->stripeToken
        ]);

        $customer->default_source = $card->id;
        $customer->save();

        return [
            'card' => $card,
            'customer' => $customer
        ];
    }
}
