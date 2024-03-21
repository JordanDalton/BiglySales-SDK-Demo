<?php

namespace App\Providers;

use BiglySales\BiglySalesAiSdk\BiglySalesAi;
use BiglySales\BiglySalesAiSdk\Requests\ObtainTokenRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('bigly', function () {

            //return Cache::remember('bigly', (60*60*24), function(){

                $token = ObtainTokenRequest::make(
                    env('BIGLY_SALES_API_USERNAME'),
                    env('BIGLY_SALES_API_PASSWORD')
                )->send()
                 ->json('token');

                return new BiglySalesAi(env('BIGLY_SALES_API_KEY'), $token);
            //});
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
