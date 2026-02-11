<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case LATE = 'late';
    case ABSENT = 'absent';

    public static function values(): array
    {
        return collect(self::cases())->pluck('value')->all();
    }
}
