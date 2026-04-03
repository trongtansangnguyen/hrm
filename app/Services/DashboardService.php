<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Repositories\EmployeeRepository;
use App\Repositories\LeaveRepository;
use App\Repositories\LogRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\CandidateRepository;
use Illuminate\Support\Facades\Cache;

class DashboardService extends ServiceBase
{
    private const CACHE_KEY_EMPLOYEE_SUMMARY = 'dashboard:employee_summary';
    private const CACHE_KEY_LEAVE_SUMMARY = 'dashboard:leave_summary';
    private const CACHE_KEY_CANDIDATE_SUMMARY = 'dashboard:candidate_summary';
    private const CACHE_KEY_RECENT_ACTIVITIES = 'dashboard:recent_activities';
    private const CACHE_KEY_DEPARTMENT_STATS = 'dashboard:department_stats';

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
        $employeeSummary = Cache::remember(
            self::CACHE_KEY_EMPLOYEE_SUMMARY,
            now()->addSeconds($this->getCacheTtl('employee_summary', 600)),
            fn () => $this->employeeRepository->summary()
        );

        $leaveSummary = Cache::remember(
            self::CACHE_KEY_LEAVE_SUMMARY,
            now()->addSeconds($this->getCacheTtl('leave_summary', 300)),
            fn () => $this->leaveRepository->summary()
        );

        $candidateSummary = Cache::remember(
            self::CACHE_KEY_CANDIDATE_SUMMARY,
            now()->addSeconds($this->getCacheTtl('candidate_summary', 600)),
            fn () => $this->candidateRepository->summary()
        );

        $recentActivities = Cache::remember(
            self::CACHE_KEY_RECENT_ACTIVITIES,
            now()->addSeconds($this->getCacheTtl('recent_activities', 60)),
            fn () => $this->logRepository->getRecentActivities(5)
        );

        $departmentStats = Cache::remember(
            self::CACHE_KEY_DEPARTMENT_STATS,
            now()->addSeconds($this->getCacheTtl('department_stats', 600)),
            fn () => $this->departmentRepository->getDepartmentStats()
        );

        return [
            'employee_summary' => $employeeSummary,
            'leave_summary' => $leaveSummary,
            'candidate_summary' => $candidateSummary,
            'recent_activities' => $recentActivities,
            'department_stats' => $departmentStats,
        ];
    }

    public function clearDashboardCache(): void
    {
        $this->forgetCacheKeys([
            self::CACHE_KEY_EMPLOYEE_SUMMARY,
            self::CACHE_KEY_LEAVE_SUMMARY,
            self::CACHE_KEY_CANDIDATE_SUMMARY,
            self::CACHE_KEY_RECENT_ACTIVITIES,
            self::CACHE_KEY_DEPARTMENT_STATS,
        ]);
    }

    public function clearEmployeeCache(): void
    {
        $this->forgetCacheKeys([
            self::CACHE_KEY_EMPLOYEE_SUMMARY,
            self::CACHE_KEY_DEPARTMENT_STATS,
            self::CACHE_KEY_RECENT_ACTIVITIES,
        ]);
    }

    public function clearLeaveCache(): void
    {
        $this->forgetCacheKeys([
            self::CACHE_KEY_LEAVE_SUMMARY,
            self::CACHE_KEY_RECENT_ACTIVITIES,
        ]);
    }

    public function clearCandidateCache(): void
    {
        $this->forgetCacheKeys([
            self::CACHE_KEY_CANDIDATE_SUMMARY,
            self::CACHE_KEY_RECENT_ACTIVITIES,
        ]);
    }

    public function clearDepartmentCache(): void
    {
        $this->forgetCacheKeys([
            self::CACHE_KEY_DEPARTMENT_STATS,
            self::CACHE_KEY_RECENT_ACTIVITIES,
        ]);
    }

    private function getCacheTtl(string $key, int $default): int
    {
        $ttl = (int) config("dashboard.cache_ttl.{$key}", $default);

        return $ttl > 0 ? $ttl : $default;
    }

    private function forgetCacheKeys(array $keys): void
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
