<?php

namespace Kamelher\Devices\app\Models;

use Illuminate\Database\Eloquent\Model;
use Kamelher\Devices\Enums\DeviceStatus;

class Device extends Model
{
    protected $fillable = [
        'name',
        'mac_address',
        'uuid',
        'status',
        'device_type',
        'device_model',
        'metadata',
    ];

    protected $casts = [
        'status' => DeviceStatus::class,
        'created_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function deviceable()
    {
        return $this->morphTo();
    }
}
