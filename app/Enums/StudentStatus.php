<?php

namespace App\Enums;

enum StudentStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function values(): array
    {

        return collect(self::cases())->pluck('value')->all();
    }
}
