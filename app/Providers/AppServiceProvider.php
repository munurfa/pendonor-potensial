<?php

namespace App\Providers;

use Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Config::set('charts.assets.highcharts.scripts', [
                asset('/js/highcharts.js'),
                asset('/js/offline-exporting.js'),
                asset('/js/map.js'),
                asset('/js/data.js'),
                asset('/js/world.js'),
            ]);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
