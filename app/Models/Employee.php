<?php

namespace App\Models;

use App\Enums\EmployeeGender;
use App\Enums\EmployeeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'identity_number',
        'join_date',
        'status',
        'department_id',
        'position_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => EmployeeGender::class,
            'status' => EmployeeStatus::class,
            'date_of_birth' => 'date',
            'join_date' => 'datetime',
        ];
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the department that the employee belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that the employee holds.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the user associated with the employee.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the attendances for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the leave requests for the employee.
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Get the salaries for the employee.
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    /**
     * Get the employee allowances.
     */
    public function employeeAllowances()
    {
        return $this->hasMany(EmployeeAllowance::class);
    }
}
