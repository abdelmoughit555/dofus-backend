<?php

namespace App\Payments;

interface Gateway
{
    public function charge($order);
}