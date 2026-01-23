<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserRole;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate để kiểm tra quyền admin
        Gate::define('is-admin', function ($user) {
            return $user->role === UserRole::ADMIN;
        });

        // Gate để kiểm tra quyền manager
        Gate::define('is-manager', function ($user) {
            return $user->role === UserRole::MANAGER;
        });

        // Gate để kiểm tra quyền employee
        Gate::define('is-employee', function ($user) {
            return $user->role === UserRole::EMPLOYEE;
        });

        // Gate để kiểm tra admin hoặc manager
        Gate::define('is-admin-or-manager', function ($user) {
            return in_array($user->role, [UserRole::ADMIN, UserRole::MANAGER]);
        });
    }
}
