<?php

namespace Kamelher\Devices\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kamelher\Devices\Enums\DeviceStatus;
use Kamelher\Devices\Enums\DeviceTypes;

class Device extends Model
{
    use hasFactory;


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
        'device_type' => DeviceTypes::class,
        'created_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function deviceable()
    {
        return $this->morphTo();
    }


}
