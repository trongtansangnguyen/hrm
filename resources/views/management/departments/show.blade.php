@extends('layouts.hrm')

@section('title', 'Chi tiết phòng ban')

@section('page-title', 'Chi tiết phòng ban')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">{{ $department->name }}</h3>
                    <p class="text-blue-100">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Tạo từ: {{ $department->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div class="text-6xl opacity-20">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Basic Information -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Thông tin cơ bản
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Department Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tên phòng ban</label>
                        <p class="text-gray-900 font-medium">{{ $department->name }}</p>
                    </div>

                    <!-- Employee Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Số lượng nhân viên</label>
                        <p class="text-gray-900 font-medium text-lg">
                            <i class="fas fa-users text-blue-500 mr-2"></i>{{ $employeeCount }}
                        </p>
                    </div>

                    <!-- Manager -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Quản lý phòng ban</label>
                        <p class="text-gray-900 font-medium">
                            @if($department->manager)
                                <i class="fas fa-user-tie text-blue-500 mr-2"></i>{{ $department->manager->full_name }} {{ $department->manager->employee_code ? "({$department->manager->employee_code})" : '' }}
                            @else
                                <span class="text-gray-400"><i class="fas fa-user-slash mr-2"></i>Không có thông tin</span>
                            @endif
                        </p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Mô tả</label>
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $department->description ?? 'Không có mô tả' }}</p>
                    </div>
                </div>
            </div>

            <!-- Department Statistics -->
            <div class="border-t pt-6 mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                    Thống kê
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $employeeCount }}</p>
                        <p class="text-sm text-gray-600 mt-1">Nhân viên</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $department->employees()->where('status', 1)->count() }}</p>
                        <p class="text-sm text-gray-600 mt-1">Đang làm việc</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-red-600">{{ $department->employees()->whereIn('status', [2, 3])->count() }}</p>
                        <p class="text-sm text-gray-600 mt-1">Đã nghỉ</p>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="border-t pt-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                    Lịch sử
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Ngày tạo</label>
                        <p class="text-gray-900">{{ $department->created_at->format('d/m/Y H:i:s') }}</p>
                        <p class="text-sm text-gray-500">{{ $department->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Cập nhật lần cuối</label>
                        <p class="text-gray-900">{{ $department->updated_at->format('d/m/Y H:i:s') }}</p>
                        <p class="text-sm text-gray-500">{{ $department->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                <a
                    href="{{ route('management.departments.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a
                    href="{{ route('management.departments.edit', $department) }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
