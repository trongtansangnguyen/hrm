<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Repositories\LogRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LogService extends ServiceBase
{
    protected LogRepository $logRepository;
    protected UserRepository $userRepository;

    public function __construct(
        LogRepository $logRepository,
        UserRepository $userRepository
    )
    {
        $this->logRepository = $logRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get paginated logs with filters
     */
    public function getPaginatedLogs(array $filters = []): LengthAwarePaginator
    {
        return $this->logRepository->getPaginatedLogs($filters);
    }

    /**
     * Get all distinct actions for filter dropdown
     */
    public function getDistinctActions(): array
    {
        return $this->logRepository->getDistinctActions();
    }

    /**
     * Get all distinct table names for filter dropdown
     */
    public function getDistinctTableNames(): array
    {
        return $this->logRepository->getDistinctTableNames();
    }

    /**
     * Get all users for filter dropdown
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->all()->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
            ];
        })->toArray();
    }

    /**
     * Create a new log entry
     */
    public function createLog(array $data): mixed
    {
        // Add IP address if not provided
        if (!isset($data['ip_address'])) {
            $data['ip_address'] = request()->ip();
        }

        // Add user_id if not provided and user is authenticated
        if (!isset($data['user_id']) && auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $this->logRepository->createLog($data);
    }

    /**
     * Log an action with automatic formatting
     */
    public function logAction(
        string $action,
        ?string $tableName = null,
        ?int $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): mixed {
        return $this->createLog([
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
