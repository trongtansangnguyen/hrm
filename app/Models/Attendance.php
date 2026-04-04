<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'working_hours',
        'date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'date' => 'date',
            'working_hours' => 'float',
            'status' => AttendanceStatus::class,
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
