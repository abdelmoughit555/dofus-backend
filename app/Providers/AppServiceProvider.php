<?php

namespace App\Providers;

use App\Cart\Cart;
use App\Models\IPUser;
use Stripe\Stripe;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
/*         $this->app->singleton(Gateway::class, function ($app) {
            $requestClass =  "\\App\\Payments\\Services\\" . request()->paymentClass;
            return new $requestClass;
        });
 */
        $this->app->singleton(Cart::class, function ($app) {
            $currency = \geoip($app->request->ip())->currency == "MAD" ?: 'EURO';

            $ip = IPUser::firstOrCreate(
                    ['ip' => $app->request->ip()],
                    ['local' => 'fr','currency' => $currency]
                );

            return new Cart($ip);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
