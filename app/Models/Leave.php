<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\LeaveRequestStatus;

class Leave extends Model
{
    protected $table = 'leave_requests';
    //

    protected $fillable = [
        
    ];

    protected $casts = [
        'status' => LeaveRequestStatus::class,
    ];
}
