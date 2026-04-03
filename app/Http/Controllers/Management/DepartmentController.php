<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Services\DepartmentService;
use App\Http\Requests\Management\StoreDepartmentRequest;
use App\Http\Requests\Management\UpdateDepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $departmentService
    ) {}

    /**
     * Display a listing of departments
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'date_from', 'date_to', 'sort_by', 'sort_order', 'per_page']);

        $departments = $this->departmentService->getPaginatedDepartments($filters);

        return view('management.departments.index', compact('departments', 'filters'));
    }

    /**
     * Show the form for creating a new department
     */
    public function create()
    {
        $employees = Employee::whereNull('deleted_at')->orderBy('first_name')->get();
        return view('management.departments.create', compact('employees'));
    }

    /**
     * Store a newly created department
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->createDepartment($request->validated());

        return redirect()
            ->route('management.departments.index')
            ->with('success', 'Tạo phòng ban thành công!');
    }

    /**
     * Display the specified department
     */
    public function show(Department $department)
    {
        $department->load('manager', 'employees');
        $employeeCount = $department->employees()->count();

        return view('management.departments.show', compact('department', 'employeeCount'));
    }

    /**
     * Show the form for editing the specified department
     */
    public function edit(Department $department)
    {
        $employees = Employee::where('department_id', $department->id)
            ->whereNull('deleted_at')
            ->orderBy('first_name')
            ->get();
        return view('management.departments.edit', compact('department', 'employees'));
    }

    /**
     * Update the specified department
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->departmentService->updateDepartment($department->id, $request->validated());

        return redirect()
            ->route('management.departments.index')
            ->with('success', 'Cập nhật phòng ban thành công!');
    }

    /**
     * Remove the specified department
     */
    public function destroy(Department $department)
    {
        try {
            $this->departmentService->deleteDepartment($department->id);

            return redirect()
                ->route('management.departments.index')
                ->with('success', 'Xóa phòng ban thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Không thể xóa phòng ban: ' . $e->getMessage());
        }
    }
}
