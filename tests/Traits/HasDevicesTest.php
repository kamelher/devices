<?php

use Illuminate\Database\Eloquent\Factories\Factory;
use Kamelher\Devices\Models\Device;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Assuming a "User" model uses the HasDevices trait.
    $this->user = \App\Models\User::factory()->create();
});

it('can retrieve devices for a model', function () {
    $devices = Device::factory()->count(3)->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
    ]);

    $retrievedDevices = $this->user->devices;

    expect($retrievedDevices->count())->toBe(3)
        ->and($retrievedDevices->pluck('id'))->toEqual($devices->pluck('id'));
});

it('can add a device to a model', function () {
    $deviceData = [
        'name' => 'Test Device',
        'mac_address' => '00:1B:44:11:3A:B7',
        'device_model' => 'Model X',
    ];

    $this->user->addDevice($deviceData);

    $device = $this->user->devices()->first();

    expect($device)
        ->name->toBe('Test Device')
        ->mac_address->toBe('00:1B:44:11:3A:B7')
        ->device_model->toBe('Model X');
});

it('can remove a device from a model', function () {
    $device = Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
    ]);

    $this->user->removeDevice($device);

    expect($this->user->devices()->find($device->id))->toBeNull();
});

it('can check if a model has a specific device', function () {
    $device = Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
    ]);

    expect($this->user->hasDevice($device))->toBeTrue();

    $nonExistentDevice = Device::factory()->make();
    expect($this->user->hasDevice($nonExistentDevice))->toBeFalse();
});

it('can check if a model has a device with a specific ID', function () {
    $device = Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
    ]);

    expect($this->user->hasDeviceWithId($device->id))->toBeTrue()
        ->and($this->user->hasDeviceWithId(999))->toBeFalse();
});

it('can check if a model has a device with a specific MAC address', function () {
    $macAddress = '00:1B:44:11:3A:B7';
    Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'mac_address' => $macAddress,
    ]);

    expect($this->user->hasDeviceWithMacAdress($macAddress))->toBeTrue()
        ->and($this->user->hasDeviceWithMacAdress('00:1B:44:11:3A:B8'))->toBeFalse();
});

it('can check if a model has a device with a specific UUID', function () {
    $uuid = Str::uuid();
    Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'uuid' => $uuid,
    ]);

    expect($this->user->hasDeviceWithUuid($uuid))->toBeTrue()
        ->and($this->user->hasDeviceWithUuid(Str::uuid()))->toBeFalse();
});

it('can check if a model has any devices', function () {
    expect($this->user->hasDevices())->toBeFalse();

    Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
    ]);

    expect($this->user->hasDevices())->toBeTrue();
});

it('does not break when adding a device with missing optional fields', function () {

    $device = [
        'name' => 'Minimal Device',
        'mac_address'=>'00:00:00:00:00:01',

    ];
    $this->user->addDevice($device);

    EXPECT($this->user->hasDevices())->toBeTrue();
    $device = $this->user->devices()->first();

    EXPECT($device)->NOT->toBeNull();

    expect($device)
        ->name->toBe('Minimal Device')
        ->uuid->not->toBeNull()
        ->mac_address->not->toBeNull()
        ->status->toBe(DeviceStatus::Unverified)
        ->device_type->toBe(DeviceTypes::Desktop);
});



it('returns a device by its MAC address', function () {
    $macAddress = '00:1B:44:11:3A:B7';

    $device = Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'mac_address' => $macAddress,
    ]);

    $retrievedDevice = $this->user->getDeviceByMacAddress($macAddress);

    expect($retrievedDevice)->not->toBeNull()
        ->and($retrievedDevice->id)->toBe($device->id);
});

it('returns null when no device matches the given MAC address', function () {
    $macAddress = '00:1B:44:11:3A:B7';

    Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'mac_address' => '00:1B:44:11:3A:B8', // Different MAC address
    ]);

    $retrievedDevice = $this->user->getDeviceByMacAddress($macAddress);

    expect($retrievedDevice)->toBeNull();
});

it('returns null when the MAC address is empty', function () {
    $retrievedDevice = $this->user->getDeviceByMacAddress(null);

    expect($retrievedDevice)->toBeNull();

    $retrievedDevice = $this->user->getDeviceByMacAddress('');

    expect($retrievedDevice)->toBeNull();
});

it('returns the first matching device when multiple devices have the same MAC address', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);
    //expect to throw an error of unique constraint violation
    $macAddress = '00:1B:44:11:3A:B7';

    $device1 = Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'mac_address' => $macAddress,
    ]);

    Device::factory()->create([
        'deviceable_id' => $this->user->id,
        'deviceable_type' => get_class($this->user),
        'mac_address' => $macAddress, // Same MAC address
    ]);

    $retrievedDevice = $this->user->getDeviceByMacAddress($macAddress);




    // Should return the first matching device
});

