<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap(); // for pagination styling with bootstrap

        // if(str_contains(env('APP_URL'), "http")) {
        //     URL::forceScheme('https');
        // }

        if (app()->environment('production') || app()->environment('development')) {
            URL::forceRootUrl('https://jedi.msya.gov.tt/' . env('APP_NAME'));
        }
    }
}
