<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Department();
    }

    /**
     * Get all departments with pagination and filters
     */
    public function getAllPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = $this->newQuery();

        $query = $this->applyFilters($query, $filters);
        $query = $this->applySorting($query, $filters);

        $perPage = $filters['per_page'] ?? 20;

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get all departments without pagination
     */
    public function getAll(): Collection
    {
        return $this->newQuery()
            ->latest()
            ->get();
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
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
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
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        }

        return $query;
    }
}

