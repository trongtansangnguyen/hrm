<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Allowance;
use App\Models\Department;
use App\Models\Employee;
use App\Services\DashboardService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService,
        protected LogService $logService
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
            $keywords = preg_split('/\s+/', $search) ?: [];

            $query->where(function ($q) use ($search, $keywords) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere(function ($nameQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $nameQuery->where(function ($tokenQuery) use ($keyword) {
                                $tokenQuery->where('first_name', 'like', "%{$keyword}%")
                                    ->orWhere('last_name', 'like', "%{$keyword}%");
                            });
                        }
                    });
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

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $allowSortBy = ['join_date', 'created_at', 'employee_code', 'first_name', 'last_name'];
        $allowSortOrder = ['asc', 'desc'];

        if (!in_array($sortBy, $allowSortBy, true)) {
            $sortBy = 'created_at';
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
        $allowances = Allowance::query()->orderBy('name')->get();

        return view('management.employees.create', compact('departments', 'allowances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'allowance_ids' => ['nullable', 'array'],
            'allowance_ids.*' => ['integer', 'exists:allowances,id'],
        ], [
            'identity_number.required' => 'CMND/CCCD là bắt buộc.',
            'identity_number.unique' => 'CMND/CCCD đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'date_of_birth.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'department_id.exists' => 'Phòng ban không tồn tại.',
            'allowance_ids.*.exists' => 'Phụ cấp không tồn tại.',
        ]);

        $employee = DB::transaction(function () use ($validated) {
            $allowanceIds = $validated['allowance_ids'] ?? [];
            $employee = Employee::create(array_merge($validated, [
                'employee_code' => $this->generateTemporaryEmployeeCode(),
            ]));

            $employee->forceFill([
                'employee_code' => $this->formatEmployeeCode($employee->id),
            ])->save();

            if (!empty($allowanceIds)) {
                $now = now();
                DB::table('employee_allowances')->insert(
                    collect($allowanceIds)
                        ->unique()
                        ->map(fn ($allowanceId) => [
                            'employee_id' => $employee->id,
                            'allowance_id' => $allowanceId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ])
                        ->values()
                        ->all()
                );
            }

            return $employee->fresh();
        });

        $this->logService->logAction(
            action: 'create_employee',
            tableName: 'employees',
            recordId: $employee->id,
            newValues: $employee->toArray()
        );

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
        $allowances = Allowance::query()->orderBy('name')->get();
        $selectedAllowanceIds = DB::table('employee_allowances')
            ->where('employee_id', $employee->id)
            ->pluck('allowance_id')
            ->map(fn ($id) => (int) $id)
            ->all();
        $employee->load('department');

        return view('management.employees.edit', compact('employee', 'departments', 'allowances', 'selectedAllowanceIds'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
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
            'allowance_ids' => ['nullable', 'array'],
            'allowance_ids.*' => ['integer', 'exists:allowances,id'],
        ], [
            'identity_number.required' => 'CMND/CCCD là bắt buộc.',
            'identity_number.unique' => 'CMND/CCCD đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'date_of_birth.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'department_id.exists' => 'Phòng ban không tồn tại.',
            'allowance_ids.*.exists' => 'Phụ cấp không tồn tại.',
        ]);

        $allowanceIds = $validated['allowance_ids'] ?? [];
        unset($validated['allowance_ids']);

        $oldValues = $employee->toArray();
        DB::transaction(function () use ($employee, $validated, $allowanceIds): void {
            $employee->update($validated);

            DB::table('employee_allowances')
                ->where('employee_id', $employee->id)
                ->delete();

            if (!empty($allowanceIds)) {
                $now = now();
                DB::table('employee_allowances')->insert(
                    collect($allowanceIds)
                        ->unique()
                        ->map(fn ($allowanceId) => [
                            'employee_id' => $employee->id,
                            'allowance_id' => $allowanceId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ])
                        ->values()
                        ->all()
                );
            }
        });

        $expectedEmployeeCode = $this->formatEmployeeCode($employee->id);
        if ($employee->employee_code !== $expectedEmployeeCode) {
            $employee->forceFill([
                'employee_code' => $expectedEmployeeCode,
            ])->save();
        }

        $this->logService->logAction(
            action: 'update_employee',
            tableName: 'employees',
            recordId: $employee->id,
            oldValues: $oldValues,
            newValues: $employee->fresh()?->toArray() ?? $employee->toArray()
        );

        $this->dashboardService->clearEmployeeCache();

        return redirect()
            ->route('management.employees.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }

    public function destroy(Employee $employee)
    {
        try {
            $oldValues = $employee->toArray();
            $employee->delete();

            $this->logService->logAction(
                action: 'delete_employee',
                tableName: 'employees',
                recordId: $employee->id,
                oldValues: $oldValues
            );

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

    private function formatEmployeeCode(int $employeeId): string
    {
        return 'EMP' . str_pad((string) $employeeId, 6, '0', STR_PAD_LEFT);
    }

    private function generateTemporaryEmployeeCode(): string
    {
        return 'TMP' . now()->format('YmdHis') . Str::upper(Str::random(8));
    }
}
