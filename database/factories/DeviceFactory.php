<?php

namespace Kamelher\Devices\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kamelher\Devices\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'mac_address' => $this->faker->macAddress,
            'status' => 'active',
            'device_type' => 'device',
            'metadata' => [
                'foo' => 'bar',
            ],
        ];
    }
}
