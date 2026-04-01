<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\LeaveController as ManagementLeaveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves');
    Route::get('/employee-leaves', [LeaveController::class, 'index'])->name('employee-leaves.index');
    Route::post('/employee-leaves', [LeaveController::class, 'store'])->name('employee-leaves.store');
    Route::delete('/employee-leaves/{leave}', [LeaveController::class, 'destroy'])
        ->name('employee-leaves.destroy');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    // Management Routes
    Route::middleware('management')->prefix('management')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('management.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('management.users.create');
            Route::post('/', [UserController::class, 'store'])->name('management.users.store');
            Route::get('/{user}', [UserController::class, 'show'])->name('management.users.show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('management.users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('management.users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('management.users.destroy');
        });

        Route::prefix('employees')->group(function () {
            // Employee routes can be added here
        });

        Route::prefix('departments')->group(function () {
            // Department routes can be added here
        });

        Route::prefix('attendances')->group(function () {
            // Attendance routes can be added here
        });

        Route::prefix('leaves')->group(function () {
            Route::get('/', [ManagementLeaveController::class, 'index'])->name('management.leaves.index');
            Route::patch('/{leave}/approve', [ManagementLeaveController::class, 'approve'])
                ->name('management.leaves.approve');
            Route::patch('/{leave}/reject', [ManagementLeaveController::class, 'reject'])
                ->name('management.leaves.reject');
        });

        Route::prefix('allowances')->group(function () {
        Route::get('/', [App\Http\Controllers\Management\AllowanceController::class, 'index'])->name('management.allowances.index');
        Route::get('/create', [App\Http\Controllers\Management\AllowanceController::class, 'create'])->name('management.allowances.create');
        Route::post('/', [App\Http\Controllers\Management\AllowanceController::class, 'store'])->name('management.allowances.store');
        // Có thể thêm edit, update, delete sau
        });

        Route::prefix('jobs')->group(function () {
            // Job routes can be added here
        });

        Route::prefix('logs')->group(function () {
            // Log routes can be added here
        });
    });
});

