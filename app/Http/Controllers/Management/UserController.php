<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\Management\StoreUserRequest;
use App\Http\Requests\Management\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'role', 'status', 'date_from', 'date_to', 'sort_by', 'sort_order', 'per_page']);
        
        $users = $this->userService->getPaginatedUsers($filters);
        
        $roles = UserRole::cases();
        $statuses = UserStatus::cases();

        return view('management.users.index', compact('users', 'filters', 'roles', 'statuses'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = UserRole::cases();
        $statuses = UserStatus::cases();
        
        return view('management.users.create', compact('roles', 'statuses'));
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Tạo thành công!');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load('employee');
        
        return view('management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $roles = UserRole::cases();
        $statuses = UserStatus::cases();
        
        return view('management.users.edit', compact('user', 'roles', 'statuses'));
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateUser($user->id, $request->validated());

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        if (!$this->userService->canDeleteUser($user->id)) {
            return redirect()
                ->route('management.users.index')
                ->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        $this->userService->deleteUser($user->id);

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Xoá thành công!');
    }
}
