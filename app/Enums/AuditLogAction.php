<?php

namespace App\Enums;

enum AuditLogAction: string
{
    //actions by admin
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';

    //action by employee
    
    //action by system


    public function label(): string
    {
        return match($this) {
            self::CREATE => 'Create',
            self::UPDATE => 'Update',
            self::DELETE => 'Delete',
        };
    }
}


