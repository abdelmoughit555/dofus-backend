<?php

namespace App\Models\Traits;

use App\Models\IPUser;

trait IP
{

    public function currency()
    {
        return $this->getIP()->currency;
    }

    public function rate()
    {
        return $this->getIP()->currency == 'MAD' ? 1 : config('services.stripe.euro');
    }

    protected function getIp()
    {
        $currency = \geoip(request()->ip())->currency == "MAD" ? 'MAD' : 'EURO';

        $ip = IPUser::firstOrCreate(
            ['ip' => request()->ip()],
            ['local' => 'fr', 'currency' => $currency]
        );

        return $ip;
    }
}