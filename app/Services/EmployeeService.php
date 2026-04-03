<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Repositories\EmployeeRepository;

class EmployeeService extends ServiceBase
{
    protected EmployeeRepository $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Get all employees have not linked user account yet
     */
    public function getAllEmployeesWithoutUserAccount($currentEmployeeId = null)
    {
        return $this->employeeRepository->getAllEmployeesWithoutUserAccount($currentEmployeeId);
    }
}
