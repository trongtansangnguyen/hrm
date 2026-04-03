<?php

namespace App\Enums;

enum EmployeeStatus: int
{
    case WORKING = 1;
    case RESIGNED = 2;
    case SUSPENDED = 3;
    case ON_DUTY = 4;
}

