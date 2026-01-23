@extends('layouts.hrm')

@section('title', 'Chi tiết người dùng')

@section('page-title', 'Chi tiết người dùng')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">{{ $user->email }}</h3>
                    <p class="text-blue-100">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Tham gia từ: {{ $user->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div class="text-6xl opacity-20">
                    <i class="fas fa-user-circle"></i>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User ID -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">ID</label>
                        <p class="text-gray-900 font-medium">#{{ $user->id }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Vai trò</label>
                        <div>
                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-{{ $user->role->badgeColor() }}-100 text-{{ $user->role->badgeColor() }}-800">
                                {{ $user->role->label() }}
                            </span>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Trạng thái</label>
                        <div>
                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-{{ $user->status->badgeColor() }}-100 text-{{ $user->status->badgeColor() }}-800">
                                {{ $user->status->label() }}
                            </span>
                        </div>
                    </div>

                    <!-- Employee -->
                    @if($user->employee)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nhân viên liên kết</label>
                            <p class="text-gray-900 font-medium">{{ $user->employee->full_name }}</p>
                        </div>
                    @endif

                    <!-- Email Verified -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email đã xác thực</label>
                        <div>
                            @if($user->email_verified_at)
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-2"></i> Đã xác thực
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Chưa xác thực
                                </span>
                            @endif
                        </div>
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
                        <label for="created_at" class="block text-sm font-medium text-gray-500 mb-1">Ngày tạo</label>
                        <p class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                        <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label for="updated_at" class="block text-sm font-medium text-gray-500 mb-1">Cập nhật lần cuối</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                        <p class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                <a 
                    href="{{ route('management.users.index') }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a 
                    href="{{ route('management.users.edit', $user) }}" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
