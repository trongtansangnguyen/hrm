<?php

namespace App\Repositories\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * The Eloquent model instance
     */
    protected Model $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * Get the model instance
     * Must be implemented by concrete repositories
     *
     * @return Model
     */
    abstract protected function getModel(): Model;

        /**
     * Get fresh query builder instance
     *
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Find a record by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function lockForUpdate(int $id): ?Model
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be positive');
        }

        return $this->newQuery()->where('id', $id)->lockForUpdate()->first();
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }

        return $this->newQuery()->create($data);
    }

    /**
     * Update record by ID
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be positive');
        }
        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }

        return $this->newQuery()->where('id', $id)->update($data) > 0;
    }

    /**
     * Delete record by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be positive');
        }
        return $this->newQuery()->where('id', $id)->delete() > 0;
    }

    /**
     * Get model table name
     * Utility method for debugging and advanced queries
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->model->getTable();
    }

    /**
     * Get model primary key
     * Utility method for dynamic queries
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->model->getKeyName();
    }

    /**
     * Find a record by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be positive');
        }
        return $this->newQuery()->find($id);
    }

    /**
     * Find a record by ID or fail
     *
     * @param int $id
     * @return Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Model
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('ID must be positive');
        }
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * Get all records
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->newQuery()->get();
    }

    /**
     * Paginate records
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 20): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->newQuery()->paginate($perPage);
    }

    /**
     * Add where condition to query
     *
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function where(string $column, $value): Builder
    {
        return $this->newQuery()->where($column, $value);
    }
    
    /**
     * Insert multiple records
     *
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Data cannot be empty');
        }
        return $this->newQuery()->insert($data);
    }
}
