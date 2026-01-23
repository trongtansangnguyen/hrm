<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case MANAGER = 2;
    case EMPLOYEE = 3;

    /**
     * Get the label for the role
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::EMPLOYEE => 'Employee',
        };
    }

    /**
     * Get the badge color for the role
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::ADMIN => 'purple',
            self::MANAGER => 'blue',
            self::EMPLOYEE => 'green',
        };
    }
}

