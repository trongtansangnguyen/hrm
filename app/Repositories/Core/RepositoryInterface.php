<?php

namespace App\Repositories\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    /**
     * Create a new record
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Update record by ID
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete record by ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get fresh query builder instance
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * Find record by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * Find record by ID or fail
     *
     * @param int $id
     * @return Model
     */
    public function findOrFail(int $id): Model;

    /**
     * Get all records
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection;

    /**
     * Paginate records
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 20): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Add where condition to query
     *
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function where(string $column, $value): Builder;

    /**
     * Insert multiple records
     *
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool;

    /**
     * Lock a record for update
     *
     * @param int $id
     * @return Model|null
     */
    public function lockForUpdate(int $id): ?Model;

    /**
     * Get model table name
     *
     * @return string
     */
    public function getTable(): string;

    /**
     * Get model primary key
     *
     * @return string
     */
    public function getPrimaryKey(): string;
}
