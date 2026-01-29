<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Repositories\EmployeeRepository;
use App\Repositories\LeaveRepository;
use App\Repositories\LogRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\CandidateRepository;

class DashboardService extends ServiceBase
{
    protected EmployeeRepository $employeeRepository;
    protected LeaveRepository $leaveRepository;
    protected LogRepository $logRepository;
    protected DepartmentRepository $departmentRepository;
    protected CandidateRepository $candidateRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        LeaveRepository $leaveRepository,
        LogRepository $logRepository,
        DepartmentRepository $departmentRepository,
        CandidateRepository $candidateRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->leaveRepository = $leaveRepository;
        $this->logRepository = $logRepository;
        $this->departmentRepository = $departmentRepository;
        $this->candidateRepository = $candidateRepository;
    }

    public function getDashboardData()
    {
        $employeeSummary = $this->employeeRepository->summary();
        $leaveSummary = $this->leaveRepository->summary();
        $candidateSummary = $this->candidateRepository->summary();

        return [
            'employee_summary' => $employeeSummary,
            'leave_summary' => $leaveSummary,
            'candidate_summary' => $candidateSummary,
        ];
    }
}
