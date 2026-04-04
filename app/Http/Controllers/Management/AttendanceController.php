<?php

namespace App\Http\Controllers\Management;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['date', 'department_id', 'employee_id', 'search']);

        $query = Attendance::query()->with(['employee.department']);

        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        if (!empty($filters['department_id'])) {
            $query->whereHas('employee', function ($employeeQuery) use ($filters) {
                $employeeQuery->where('department_id', (int) $filters['department_id']);
            });
        }

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', (int) $filters['employee_id']);
        }

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);
            $query->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery
                    ->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ["%{$search}%"])
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
            });
        }

        $perPage = (int) config('attendance.management_per_page', 15);
        if ($perPage <= 0) {
            $perPage = 15;
        }

        $attendances = $query
            ->latest('date')
            ->latest('check_in')
            ->paginate($perPage)
            ->withQueryString();

        $summaryBaseQuery = Attendance::query();

        if (!empty($filters['date'])) {
            $summaryBaseQuery->whereDate('date', $filters['date']);
        }

        if (!empty($filters['department_id'])) {
            $summaryBaseQuery->whereHas('employee', function ($employeeQuery) use ($filters) {
                $employeeQuery->where('department_id', (int) $filters['department_id']);
            });
        }

        if (!empty($filters['employee_id'])) {
            $summaryBaseQuery->where('employee_id', (int) $filters['employee_id']);
        }

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);
            $summaryBaseQuery->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery
                    ->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ["%{$search}%"])
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
            });
        }

        $summary = [
            'total' => (clone $summaryBaseQuery)->count(),
            'on_time' => (clone $summaryBaseQuery)->where('status', AttendanceStatus::ON_TIME)->count(),
            'late' => (clone $summaryBaseQuery)->where('status', AttendanceStatus::LATE)->count(),
            'absent' => (clone $summaryBaseQuery)->where('status', AttendanceStatus::ABSENT)->count(),
        ];

        $departments = Department::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $employees = Employee::query()
            ->when(!empty($filters['department_id']), function ($employeeQuery) use ($filters) {
                $employeeQuery->where('department_id', (int) $filters['department_id']);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id', 'employee_code', 'first_name', 'last_name']);

        return view('management.attendances.index', compact('attendances', 'filters', 'summary', 'departments', 'employees'));
    }
}
