<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'department_id',
            'gender',
            'status',
            'sort_by',
            'sort_order',
            'per_page',
        ]);

        $query = Employee::query()->with(['department']);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['gender']) && $filters['gender'] !== '') {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        $sortBy = $filters['sort_by'] ?? 'join_date';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $allowSortBy = ['join_date', 'created_at', 'employee_code', 'first_name', 'last_name'];
        $allowSortOrder = ['asc', 'desc'];

        if (!in_array($sortBy, $allowSortBy, true)) {
            $sortBy = 'join_date';
        }

        if (!in_array($sortOrder, $allowSortOrder, true)) {
            $sortOrder = 'desc';
        }

        $perPage = (int) ($filters['per_page'] ?? 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }

        $employees = $query->orderBy($sortBy, $sortOrder)->paginate($perPage)->withQueryString();

        $departments = Department::query()->orderBy('name')->get();

        return view('management.employees.index', compact('employees', 'filters', 'departments'));
    }

    public function create()
    {
        $departments = Department::query()->orderBy('name')->get();

        return view('management.employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_code' => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'identity_number' => ['required', 'string', 'max:50', 'unique:employees,identity_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'join_date' => ['required', 'date'],
            'gender' => ['required', 'integer', 'in:0,1,2'],
            'status' => ['required', 'integer', 'in:1,2,3'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'employee_code.required' => 'Mã nhân viên là bắt buộc.',
            'employee_code.unique' => 'Mã nhân viên đã tồn tại.',
            'identity_number.required' => 'CMND/CCCD là bắt buộc.',
            'identity_number.unique' => 'CMND/CCCD đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'date_of_birth.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'department_id.exists' => 'Phòng ban không tồn tại.',
        ]);

        Employee::create($validated);
        $this->dashboardService->clearEmployeeCache();

        return redirect()
            ->route('management.employees.index')
            ->with('success', 'Tạo nhân viên thành công!');
    }

    public function show(Employee $employee)
    {
        $employee->load('department');

        return view('management.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::query()->orderBy('name')->get();
        $employee->load('department');

        return view('management.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_code' => ['required', 'string', 'max:50', Rule::unique('employees', 'employee_code')->ignore($employee->id)],
            'identity_number' => ['required', 'string', 'max:50', Rule::unique('employees', 'identity_number')->ignore($employee->id)],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employee->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'join_date' => ['required', 'date'],
            'gender' => ['required', 'integer', 'in:0,1,2'],
            'status' => ['required', 'integer', 'in:1,2,3'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'employee_code.required' => 'Mã nhân viên là bắt buộc.',
            'employee_code.unique' => 'Mã nhân viên đã tồn tại.',
            'identity_number.required' => 'CMND/CCCD là bắt buộc.',
            'identity_number.unique' => 'CMND/CCCD đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'date_of_birth.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'department_id.exists' => 'Phòng ban không tồn tại.',
        ]);

        $employee->update($validated);
        $this->dashboardService->clearEmployeeCache();

        return redirect()
            ->route('management.employees.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            $this->dashboardService->clearEmployeeCache();

            return redirect()
                ->route('management.employees.index')
                ->with('success', 'Xóa nhân viên thành công!');
        } catch (\Throwable $e) {
            return redirect()
                ->route('management.employees.index')
                ->with('error', 'Không thể xóa nhân viên này do còn dữ liệu liên quan.');
        }
    }
}
