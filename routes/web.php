<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\EmployeeController;
use App\Http\Controllers\Management\DepartmentController;
use App\Http\Controllers\Management\LeaveController as ManagementLeaveController;
use App\Http\Controllers\Management\AllowanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PublicCandidateController;

Route::get('/', function () {
    return view('welcome');
});

         // Trang hiển thị form đăng ký ứng tuyển
        Route::get('/tuyen-dung', [PublicCandidateController::class, 'create'])->name('public.candidates.create');
        // Xử lý lưu dữ liệu ứng viên gửi lên
        Route::post('/tuyen-dung', [PublicCandidateController::class, 'store'])->name('public.candidates.store');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves');
    Route::get('/employee-leaves', [LeaveController::class, 'index'])->name('employee-leaves.index');
    Route::post('/employee-leaves', [LeaveController::class, 'store'])->name('employee-leaves.store');
    Route::delete('/employee-leaves/{leave}', [LeaveController::class, 'destroy'])
        ->name('employee-leaves.destroy');

    Route::middleware('management')->group(function () {
        Route::get('/logs', [LogController::class, 'index'])->name('logs');
    });
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
            Route::get('/', [EmployeeController::class, 'index'])->name('management.employees.index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('management.employees.create');
            Route::post('/', [EmployeeController::class, 'store'])->name('management.employees.store');
            Route::get('/{employee}', [EmployeeController::class, 'show'])->name('management.employees.show');
            Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('management.employees.edit');
            Route::put('/{employee}', [EmployeeController::class, 'update'])->name('management.employees.update');
            Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('management.employees.destroy');
        });

        Route::prefix('departments')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('management.departments.index');
            Route::get('/create', [DepartmentController::class, 'create'])->name('management.departments.create');
            Route::post('/', [DepartmentController::class, 'store'])->name('management.departments.store');
            Route::get('/{department}', [DepartmentController::class, 'show'])->name('management.departments.show');
            Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('management.departments.edit');
            Route::put('/{department}', [DepartmentController::class, 'update'])->name('management.departments.update');
            Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('management.departments.destroy');
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
        Route::prefix('candidates')->group(function () {
            Route::get('/', [App\Http\Controllers\Management\CandidateController::class, 'index'])->name('management.candidates.index');
            Route::get('/{candidate}', [App\Http\Controllers\Management\CandidateController::class, 'show'])->name('management.candidates.show');
            Route::patch('/{candidate}/status', [App\Http\Controllers\Management\CandidateController::class, 'updateStatus'])->name('management.candidates.updateStatus');
        });

        Route::prefix('allowances')->group(function () {
            Route::get('/', [AllowanceController::class, 'index'])->name('management.allowances.index');
            Route::get('/create', [AllowanceController::class, 'create'])->name('management.allowances.create');
            Route::post('/', [AllowanceController::class, 'store'])->name('management.allowances.store');
            Route::get('/{type}/edit', [AllowanceController::class, 'edit'])->name('management.allowances.edit');
            Route::put('/{type}', [AllowanceController::class, 'update'])->name('management.allowances.update');
            Route::delete('/{type}', [AllowanceController::class, 'destroy'])->name('management.allowances.destroy');
            });

        Route::prefix('jobs')->group(function () {
            // Job routes can be added here
        });

        Route::prefix('logs')->group(function () {
            // Log routes can be added here
        });
    });
});

