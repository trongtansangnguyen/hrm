<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService extends ServiceBase
{
    protected UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Get paginated users with filters
     */
    public function getPaginatedUsers(array $filters = []): LengthAwarePaginator
    {
        return $this->userRepository->getAllPaginated($filters);
    }

    /**
     * Find user by ID
     */
    public function findUser(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Create new user
     */
    public function createUser(array $data): User
    {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->create($data);
    }

    /**
     * Update user
     */
    public function updateUser(int $userId, array $data): bool
    {
        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->userRepository->update($userId, $data);
    }

    /**
     * Delete user
     */
    public function deleteUser(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * Check if user can be deleted
     */
    public function canDeleteUser(int $userId): bool
    {
        // Prevent deleting yourself
        return $userId !== auth()->id();
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        return $this->userRepository->emailExists($email, $excludeId);
    }
}
