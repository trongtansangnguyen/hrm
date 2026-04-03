<?php

namespace App\Enums;

enum EmployeeGender: int
{
    case MALE = 0;
    case FEMALE = 1;
    case OTHER = 2;

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Nam',
            self::FEMALE => 'Nữ',
            self::OTHER => 'Khác',
        };
    }
}
