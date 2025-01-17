<?php

namespace Kamelher\Devices;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class DeviceManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/devices.php', 'devices');

    }
    public function boot()
    {


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/database/migrations' => database_path('migrations'),
            ], 'devices-manager-migrations');

            $this->publishes([
                __DIR__ . '/config' => config_path(),
            ], 'devices-manager-config');

            $this->publishes([
                __DIR__ . '/database/factories' => database_path('factories'),
            ], 'devices-manager-factories');
        }
    }

}
