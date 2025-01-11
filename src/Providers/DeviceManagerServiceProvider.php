<?php

namespace Kamelher\Devices\Providers;

use Illuminate\Support\ServiceProvider;

class DeviceManagerServiceProvider extends ServiceProvider
{
    public function register()
    {

    }
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'devices-manager-migrations');
            
            $this->publishes([
                __DIR__ . '/../config' => config_path(),
            ], 'devices-manager-config');
        }
    }

}
