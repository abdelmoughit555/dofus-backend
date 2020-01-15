<?php

namespace App\Payments\Services;

use App\Payments\Gateway;
use PayPal\Api\Payment;

class PayPalPayment implements Gateway
{
    public function charge($order)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client'),
                config('services.paypal.secret')
            )
        );

        $paymentId = request()->paymentID;
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(request()->payerID);

        try {
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $ex) {
            echo $ex;
            exit(1);
        }
        return $result;
    }
}