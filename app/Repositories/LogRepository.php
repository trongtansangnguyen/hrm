<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LogRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Log();
    }

    /**
     * Get paginated logs with filters
     */
    public function getPaginatedLogs(array $filters = []): LengthAwarePaginator
    {
        $query = $this->newQuery()->with('user');

        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('table_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        }

        // User filter
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Action filter
        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        // Table name filter
        if (!empty($filters['table_name'])) {
            $query->where('table_name', $filters['table_name']);
        }

        // Date range filter
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $filters['per_page'] ?? 20;
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get all distinct actions
     */
    public function getDistinctActions(): array
    {
        return $this->newQuery()
            ->distinct()
            ->pluck('action')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Get all distinct table names
     */
    public function getDistinctTableNames(): array
    {
        return $this->newQuery()
            ->distinct()
            ->pluck('table_name')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Create a new log entry
     */
    public function createLog(array $data): Log
    {
        return $this->create($data);
    }
}
