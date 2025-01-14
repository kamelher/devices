# Laravel Device Manager

[![Latest Stable Version](https://poser.pugx.org/your-vendor-name/laravel-device-manager/v/stable)](https://packagist.org/packages/your-vendor-name/laravel-device-manager)
[![Total Downloads](https://poser.pugx.org/your-vendor-name/laravel-device-manager/downloads)](https://packagist.org/packages/your-vendor-name/laravel-device-manager)
[![License](https://poser.pugx.org/your-vendor-name/laravel-device-manager/license)](https://packagist.org/packages/your-vendor-name/laravel-device-manager)

Laravel Device Manager is a powerful and flexible package that simplifies the process of adding and managing devices for any model within your Laravel application. It provides a convenient way to associate devices with users, locations, or any other entity represented by an Eloquent model.

## Features

*   **Seamless Integration:** Easily integrate device management into your existing Laravel models with minimal code.
*   **Polymorphic Relationships:** Supports polymorphic relationships, allowing you to associate devices with various model types (e.g., users, locations, organizations).
*   **Customizable Device Model:**  Provides a default `Device` model that you can extend and customize to fit your specific needs.
*   **Flexible Device Attributes:**  Store essential device information like name, model, MAC address, metadata, and more.
*   **Simplified Device Creation:** Streamlined device creation process using a custom `DeviceFactory`.
*   **Event-Driven Architecture:**  Leverages Eloquent events for easy integration with your application's logic.
*   **Well-Tested:** Includes comprehensive test suite to ensure reliability.

## Installation

1.  Install the package via Composer:

    ```bash
    composer require kamelher/laravel-device-manager
    ```

2.  Publish the migration file:

    ```bash
    php artisan vendor:publish --provider="Kamelher\Devices\DeviceManagerServiceProvider" --tag="devices-manager-migrations"
    ```

3.  Run the migrations to create the `devices` table:

    ```bash
    php artisan migrate
    ```

4.  (Optional) Publish the configuration file to customize the `Device` model and other settings:

    ```bash
    php artisan vendor:publish --provider="Kamelher\Devices\DeviceManagerServiceProvider" --tag="devices-manager-config"
    ```

## Usage

### 1. Add the `HasDevices` Trait

Add the `HasDevices` trait to any Eloquent model that you want to associate with devices:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use use Kamelher\Devices\app\Traits\HasDevices;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasDevices;

    // ...
}
