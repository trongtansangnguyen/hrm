<?php

namespace App\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    /**
     * Get the label for the status
     */
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Không hoạt động',
        };
    }

    /**
     * Get the badge color for the status
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'red',
        };
    }

    /**
     * Get the icon for the status
     */
    public function icon(): string
    {
        return match($this) {
            self::ACTIVE => 'fa-check-circle',
            self::INACTIVE => 'fa-times-circle',
        };
    }
}
