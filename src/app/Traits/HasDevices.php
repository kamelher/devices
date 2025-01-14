<?php

namespace Kamelher\Devices\app\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kamelher\Devices\app\Models\Device;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;

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
    public function addDevice(array $device): self
    {
        try {
            $device['uuid'] = $device['uuid'] ?? Str::uuid();
            $device['status'] = $device['status'] ?? DeviceStatus::Unverified->value;
            $device['device_type'] = $device['device_type'] ?? DeviceTypes::Desktop->value;
            $this->devices()->create($device);
        }
        catch (\Exception $e) {
           Log::error($e->getMessage());
        }
        return $this;
    }

    /**
     * Remove a device for the Model.
     */
    public function removeDevice(?Device $device):self
    {

        if (is_null($device)) {
            return $this;
        }

        $this->devices()->where('id', $device->id)->delete();
        return $this;
    }

    /**
     * Check if the Model has a device.
     */
    public function hasDevice(?Device $device):bool
    {
        if (is_null($device)) {
            return false;
        }
        return $this->devices()->where('id', $device->id)->exists();
    }

    /**
     * Check if the Model has a device with the given ID.
     */
    public function hasDeviceWithId(int $id):bool
    {
        if ($id < 1) {
            return false;
        }

        return $this->devices()->where('id', $id)->exists();
    }
    /**
     * Check if the Model has a device with the given mac_adress.
     */
    public function hasDeviceWithMacAdress(?string $mac_adress):bool
    {
        if (empty($mac_adress)) {
            return false;
        }
        return $this->devices()->where('mac_address', $mac_adress)->exists();
    }

    /**
     * Check if the Model has a device with the given UUID.
     */
    public function hasDeviceWithUuid(?string $uuid):bool
    {
        if (empty($uuid)) {
            return false;
        }

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
