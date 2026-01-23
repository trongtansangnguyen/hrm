<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EmployeeStatus;

class EmployeeRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Employee();
    }

    public function summary(): array
    {
        $allEmployees = $this->countAllEmployees();
        $workingEmployees = $this->countAllWorkingEmployees();
        $odds = $allEmployees > 0 ? round(($workingEmployees / $allEmployees) * 100, 2) : 0;

        return [
            'total_employees' => $allEmployees,
            'working_employees' => $workingEmployees,
            'working_percentage' => $odds,
        ];
    }

    /**
     * Get count all employees
     */
    public function countAllEmployees(): int
    {
        return $this->newQuery()->count();
    }

    /**
     * Get count all employees with status working
     */
    public function countAllWorkingEmployees(): int
    {
        return $this->newQuery()->where('status', EmployeeStatus::WORKING)->count();
    }
}
