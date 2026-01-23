<?php

namespace App\Enums;

enum LeaveRequestStatus: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
}
