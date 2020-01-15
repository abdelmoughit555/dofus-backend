<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\IPResource;
use App\Models\IPUser;

class IpController extends Controller
{
    public function __invoke()
    {
        $ip = \geoip(request()->ip());

        $ip = IPUser::firstOrCreate(
            ['ip' => request()->ip()],
            [
                'local' => 'fr',
                'currency' => $ip->currency == "MAD" ? "MAD" : "EURO",
                'country' => $ip->country
            ]
        );

        return new IPResource($ip);
    }
}