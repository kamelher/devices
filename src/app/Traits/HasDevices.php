<?php

namespace Kamelher\Devices\app\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kamelher\Devices\app\Models\Device;

trait HasDevices
{
    /**
     * Get all the devices for the Model.
     */
    public function devices(): MorphMany
    {
        return $this->morphMany(Device::class, 'deviceable');
    }

    /**
     * Add a device to the Model.
     */
    public function addDevice(Device $device):self
    {
        return $this->devices()->create($device);
    }

    /**
     * Remove a device for the Model.
     */
    public function removeDevice(Device $device):self
    {
        return $this->devices()->delete($device);
    }

    /**
     * Update a device for the Model.
     */
    public function updateDevice(Device $device):self
    {
        return $this->devices()->update($device);
    }
    /**
     * Check if the Model has a device.
     */
    public function hasDevice(Device $device):bool
    {
        return $this->devices()->where('id', $device->id)->exists();
    }

    /**
     * Check if the Model has a device with the given ID.
     */
    public function hasDeviceWithId(int $id):bool
    {
        return $this->devices()->where('id', $id)->exists();
    }
    /**
     * Check if the Model has a device with the given mac_adress.
     */
    public function hasDeviceWithMacAdress(string $mac_adress):bool
    {
        return $this->devices()->where('mac_adress', $mac_adress)->exists();
    }

    /**
     * Check if the Model has a device with the given UUID.
     */
    public function hasDeviceWithUuid(string $uuid):bool
    {
        return $this->devices()->where('uuid', $uuid)->exists();
    }

    /**
     * Test if the Model has a device
     */
    public function hasDevices():bool
    {
        return $this->devices()->exists();
    }
}
