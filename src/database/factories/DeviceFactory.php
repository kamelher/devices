<?php

namespace Kamelher\Devices\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Device 1',
            'mac_address' => '00:00:00:00:00:00',
            'uuid'=> Str::uuid(),
            'status'=> DeviceStatus::Unverified->value,
            'device_type' => DeviceTypes::Desktop->value,
        ];
    }
}
