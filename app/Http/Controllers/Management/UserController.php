<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\Management\StoreUserRequest;
use App\Http\Requests\Management\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'role', 'status', 'date_from', 'date_to', 'sort_by', 'sort_order', 'per_page']);
        
        $users = $this->userRepository->getAllPaginated($filters);
        
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
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        $this->userRepository->create($validated);

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
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $this->userRepository->update($user, $validated);

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('management.users.index')
                ->with('error', 'Không thể xóa tài khoản của chính mình!');
        }

        $this->userRepository->delete($user);

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Xoá thành công!');
    }
}
