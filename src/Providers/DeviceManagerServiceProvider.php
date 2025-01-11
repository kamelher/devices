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
        $this->publishes([
            __DIR__ . '/../../config/device-manager.php' => config_path('device-manager.php'),
        ]);
    }

}
