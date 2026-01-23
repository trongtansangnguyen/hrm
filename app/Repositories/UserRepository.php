<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(
        protected User $model
    ) {}

    /**
     * Get all users with pagination and filters
     */
    public function getAllPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with('employee');

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
        return $this->model
            ->with('employee')
            ->latest()
            ->get();
    }

    /**
     * Find user by ID
     */
    public function findById(int $id): ?User
    {
        return $this->model
            ->with('employee')
            ->find($id);
    }

    /**
     * Create new user
     */
    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Update user
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete user
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = $this->model->where('email', $email);
        
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
