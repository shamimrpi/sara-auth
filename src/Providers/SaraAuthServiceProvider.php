<?php

namespace Shamimrpi\SaraAuth\Providers;

use Illuminate\Support\ServiceProvider;

class SaraAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/sara_auth.php', 'sara_auth');
    }

    public function boot()
    {
        // Config publish
        $this->publishes([
            __DIR__.'/../../config/sara_auth.php' => config_path('sara_auth.php'),
        ], 'config');

        // Route load
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        // Migration load
       $this->loadMigrationsFrom(realpath(__DIR__.'/../../database/migrations'));
    }
}
