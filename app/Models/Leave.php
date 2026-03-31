<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\LeaveRequestStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    protected $table = 'leave_requests';

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'reason',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'status' => LeaveRequestStatus::class,
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
