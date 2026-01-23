<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Core\RepositoryAbstract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new User();
    }

    /**
     * Get all users with pagination and filters
     */
    public function getAllPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = $this->newQuery()->with('employee');

        $query = $this->applyFilters($query, $filters);
        $query = $this->applySorting($query, $filters);

        $perPage = $filters['per_page'] ?? 20;

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get all users without pagination
     */
    public function getAll(): Collection
    {
        return $this->newQuery()
            ->with('employee')
            ->latest()
            ->get();
    }

    /**
     * Find user by ID with relations
     */
    public function findById(int $id): ?User
    {
        return $this->newQuery()
            ->with('employee')
            ->find($id);
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = $this->newQuery()->where('email', $email);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Apply filters to query
     */
    protected function applyFilters($query, array $filters)
    {
        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhereHas('employee', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%");
                  });
            });
        }

        // Role filter
        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // Status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Date from filter
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        // Date to filter
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }

    /**
     * Apply sorting to query
     */
    protected function applySorting($query, array $filters)
    {
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        if ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        }

        return $query;
    }
}
