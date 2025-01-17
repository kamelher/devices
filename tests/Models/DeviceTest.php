<?php

namespace Kamelher\Devices\Tests\Unit\Models;

use App\Models\User;
use Kamelher\Devices\Models\Device;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;

test('to array', function () {
  $device = Device::factory()->create()->refresh();
  expect(array_keys($device->toArray()))
      ->toBe([
          'id',
          'name',
          'mac_address',
          'uuid', 'status',
          'device_type',
          'device_model',
          'metadata',
          'deviceable_type',
          'deviceable_id',
          'created_at',
          'updated_at',
      ]);
});

test('deviceable instance', function () {
  $device = Device::factory()->create()->refresh();
  expect($device->deviceable)->toBeInstanceOf(User::class);
});



it('can create a device', function () {
    $device = Device::factory()->create([
        'name' => 'Test Device',
        'mac_address' => '00:1B:44:11:3A:B7',
        'uuid' => '123e4567-e89b-12d3-a456-426614174000',
        'status' => DeviceStatus::Active,
        'device_type' => DeviceTypes::Desktop->value,
        'device_model' => 'Model X',
        'metadata' => ['key' => 'value'],
        'deviceable_id' => User::factory()->create()->id,
        'deviceable_type' => User::class,
    ]);

    expect($device)
        ->name->toBe('Test Device')
        ->mac_address->toBe('00:1B:44:11:3A:B7')
        ->uuid->toBe('123e4567-e89b-12d3-a456-426614174000')
        ->status->toBe(DeviceStatus::Active)
        ->device_type->toBe(DeviceTypes::Desktop)
        ->device_model->toBe('Model X')
        ->metadata->toBe(['key' => 'value']);
});

it('ensures casts are applied', function () {
    $device = Device::factory()->make([
        'status' => DeviceStatus::Active->value,
        'device_type' => DeviceTypes::Desktop->value,
        'metadata' => ['key' => 'value'],
    ]);

    expect($device->status)->toBeInstanceOf(DeviceStatus::class)
        ->and($device->device_type)->toBeInstanceOf(DeviceTypes::class)
        ->and($device->metadata)->toBeArray();
});

it('can access the deviceable relationship', function () {
    $deviceable = \App\Models\User::factory()->create(); // Example morphable model
    $device = Device::factory()->create([
        'deviceable_id' => $deviceable->id,
        'deviceable_type' => get_class($deviceable),
    ]);

    expect($device->deviceable)->toBeInstanceOf(get_class($deviceable))
        ->and($device->deviceable->id)->toBe($deviceable->id);
});

it('can handle invalid data gracefully', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Device::factory()->create([
        'mac_address' => null, // Assuming 'mac_address' is required in the database schema
    ]);
});

it('fails to create a device with missing required fields', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Device::factory()->create([
        'uuid' => null, // Assuming 'name' is required in the database schema
    ]);
});

it('can update a device', function () {
    $device = Device::factory()->create();

    $device->update([
        'name' => 'Updated Device',
        'status' => DeviceStatus::Inactive,
    ]);

    expect($device->fresh())
        ->name->toBe('Updated Device')
        ->status->toBe(DeviceStatus::Inactive);
});

it('can delete a device', function () {
    $device = Device::factory()->create();

    $device->delete();

    expect(Device::find($device->id))->toBeNull();
});

it('ensures metadata is cast as an array', function () {
    $device = Device::factory()->create([
        'metadata' => ['key1' => 'value1', 'key2' => 'value2'],
    ]);

    expect($device->metadata)
        ->toBeArray()
        ->toMatchArray(['key1' => 'value1', 'key2' => 'value2']);
});

it('ensures status is an instance of DeviceStatus enum', function () {
    $device = Device::factory()->create([
        'status' => DeviceStatus::Active->value,
    ]);

    expect($device->status)->toBeInstanceOf(DeviceStatus::class);
});

it('ensures device_type is an instance of DeviceTypes enum', function () {
    $device = Device::factory()->create([
        'device_type' => DeviceTypes::Desktop->value,
    ]);

    expect($device->device_type)->toBeInstanceOf(DeviceTypes::class);
});

it('validates unique UUIDs', function () {
    $uuid = '123e4567-e89b-12d3-a456-426614174000';

    Device::factory()->create(['uuid' => $uuid]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    Device::factory()->create(['uuid' => $uuid]); // Should fail if 'uuid' is unique in the database schema
});

it('filters devices by status', function () {
    Device::factory()->count(3)->create(['status' => DeviceStatus::Active->value]);
    Device::factory()->count(2)->create(['status' => DeviceStatus::Inactive->value]);

    $activeDevices = Device::where('status', DeviceStatus::Active)->get();
    $inactiveDevices = Device::where('status', DeviceStatus::Inactive)->get();

    expect($activeDevices)->toHaveCount(3)
        ->and($inactiveDevices)->toHaveCount(2);
});

