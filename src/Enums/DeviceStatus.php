<?php

namespace Kamelher\Devices\Enums;

enum DeviceStatus: string
{
    case Unverified = 'unverified';
    case Verified = 'verified';
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';


    public function value(): array
    {
        return [
            'unverified' => 'Unverified',
            'verified' => 'Verified',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended',
        ];
    }
}
