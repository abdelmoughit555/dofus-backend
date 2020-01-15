<?php

namespace App\Http\Middleware;

use Closure;

class AddCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currency = \geoip(request()->ip())->currency == "MAD" ? 'MAD' : 'EURO';

        if ($currency == 'EURO' && $request->type == "sell") {
            return abort(404);
        }

        return $next($request);
    }
}