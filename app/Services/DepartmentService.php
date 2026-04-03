<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\Cast\Bool_;

class DepartmentService extends ServiceBase
{
    protected DepartmentRepository $departmentRepository;
    protected LogService $logService;

    public function __construct(
        DepartmentRepository $departmentRepository,
        LogService $logService
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->logService = $logService;
    }

    /**
     * Get paginated departments with filters
     */
    public function getPaginatedDepartments(array $filters = []): LengthAwarePaginator
    {
        return $this->departmentRepository->getAllPaginated($filters);
    }

    /**
     * Find department by ID
     */
    public function findDepartment(int $id): ?Department
    {
        return $this->departmentRepository->find($id);
    }

    /**
     * Create new department
     */
    public function createDepartment(array $data): Department
    {
        DB::beginTransaction();
        try {
            $department = $this->departmentRepository->create($data);

            // Log the action
            $this->logService->logAction(
                action: 'create_department',
                tableName: 'departments',
                recordId: $department->id,
                newValues: $data
            );

            DB::commit();
            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update department
     */
    public function updateDepartment(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $department = $this->departmentRepository->find($id);
            if (!$department) {
                throw new \Exception("Department not found");
            }

            $oldValues = $department->toArray();
            $department = $this->departmentRepository->update($id, $data);

            // Log the action
            $this->logService->logAction(
                action: 'update_department',
                tableName: 'departments',
                recordId: $id,
                oldValues: $oldValues,
                newValues: $data
            );

            DB::commit();
            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete department
     */
    public function deleteDepartment(int $id): bool
    {
        DB::beginTransaction();
        try {
            $department = $this->departmentRepository->findById($id);
            if (!$department) {
                throw new \Exception("Department not found");
            }

            // Log the action
            $this->logService->logAction(
                action: 'delete_department',
                tableName: 'departments',
                recordId: $department->id,
                oldValues: $department->toArray()
            );

            $this->departmentRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get all departments for dropdown
     */
    public function getAllDepartments()
    {
        return $this->departmentRepository->getModel()
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }
}
