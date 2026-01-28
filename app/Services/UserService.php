<?php

namespace App\Services;

use App\Services\Core\ServiceBase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService extends ServiceBase
{
    protected UserRepository $userRepository;
    protected LogService $logService;

    public function __construct(
        UserRepository $userRepository,
        LogService $logService
    ) {
        $this->userRepository = $userRepository;
        $this->logService = $logService;
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

        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($data);
            
            // Log the action
            $this->logService->logAction(
                action: 'create_user',
                tableName: 'users',
                recordId: $user->id,
                newValues: [
                    'email' => $user->email,
                    'role' => $user->role->value,
                    'status' => $user->status->value,
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $user;
    }

    /**
     * Update user
     */
    public function updateUser(int $userId, array $data): bool
    {
        // Get old values before update
        $oldUser = $this->userRepository->findById($userId);
        $oldValues = [
            'email' => $oldUser->email,
            'role' => $oldUser->role->value,
            'status' => $oldUser->status->value,
        ];

        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        DB::beginTransaction();
        try {

            $result = $this->userRepository->update($userId, $data);

            if ($result) {
                // Get new values after update
                $newUser = $this->userRepository->findById($userId);
                $newValues = [
                    'email' => $newUser->email,
                    'role' => $newUser->role->value,
                    'status' => $newUser->status->value,
                ];

                // Log the action
                $this->logService->logAction(
                    action: 'update_user',
                    tableName: 'users',
                    recordId: $userId,
                    oldValues: $oldValues,
                    newValues: $newValues
                );
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $result;
    }

    /**
     * Delete user
     */
    public function deleteUser(int $userId): bool
    {
        // Get user data before deletion
        $user = $this->userRepository->findById($userId);
        $oldValues = [
            'email' => $user->email,
            'role' => $user->role->value,
            'status' => $user->status->value,
        ];

        DB::beginTransaction();
        try {
            $result = $this->userRepository->delete($userId);

            if ($result) {
                // Log the action
                $this->logService->logAction(
                    action: 'delete_user',
                    tableName: 'users',
                    recordId: $userId,
                    oldValues: $oldValues
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $result;
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
