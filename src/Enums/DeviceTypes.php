<?php


namespace Kamelher\Devices\Enums;

Enum DeviceTypes : string{
    case Phone = 'phone';
    case Tablet = 'tablet';
    case Laptop = 'laptop';
    case Desktop = 'desktop';
    case SmartWatch = 'smart_watch';
    case SmartTV = 'smart_tv';
    case SmartHome = 'smart_home';
    case IoT = 'iot';
    case Other = 'other';


    public function value(): array
    {
        return [
            'phone' => 'Phone',
            'tablet' => 'Tablet',
            'laptop' => 'Laptop',
            'desktop' => 'Desktop',
            'smart_watch' => 'Smart Watch',
            'smart_tv' => 'Smart TV',
            'smart_home' => 'Smart Home',
            'iot' => 'IoT',
            'other' => 'Other',
        ];
    }
}
