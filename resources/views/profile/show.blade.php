@extends('layouts.hrm')

@section('page-title', 'Thông tin cá nhân')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Account Information Card -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-lg font-bold text-white">Thông tin tài khoản</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <p class="text-gray-900 text-lg">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Vai trò</label>
                    <p class="text-gray-900 text-lg">
                        @switch($user->role->value)
                            @case('admin')
                                <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Admin</span>
                                @break
                            @case('manager')
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Quản lý</span>
                                @break
                            @case('employee')
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Nhân viên</span>
                                @break
                            @default
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Người dùng</span>
                        @endswitch
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Trạng thái tài khoản</label>
                    <p class="text-gray-900 text-lg">
                        @if($user->status->label())
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Hoạt động</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Không hoạt động</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Information Card (if linked) -->
    @if($employee)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 px-6 py-4">
            <h2 class="text-lg font-bold text-white">Thông tin nhân viên</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Mã nhân viên</label>
                    <p class="text-gray-900 text-lg">{{ $employee->employee_code }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Họ và tên</label>
                    <p class="text-gray-900 text-lg">{{ $employee->full_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Giới tính</label>
                    <p class="text-gray-900 text-lg">
                        @if($employee->gender->value === 'male')
                            Nam
                        @elseif($employee->gender->value === 'female')
                            Nữ
                        @else
                            Khác
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Ngày sinh</label>
                    <p class="text-gray-900 text-lg">{{ $employee->date_of_birth?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Số điện thoại</label>
                    <p class="text-gray-900 text-lg">{{ $employee->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <p class="text-gray-900 text-lg">{{ $employee->email ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Địa chỉ</label>
                    <p class="text-gray-900 text-lg">{{ $employee->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Số CMND/CCCD</label>
                    <p class="text-gray-900 text-lg">{{ $employee->identity_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Ngày vào làm</label>
                    <p class="text-gray-900 text-lg">{{ $employee->join_date?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Phòng ban</label>
                    <p class="text-gray-900 text-lg">{{ $employee->department?->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Vị trí</label>
                    <p class="text-gray-900 text-lg">{{ $employee->position?->title ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Trạng thái</label>
                    <p class="text-gray-900 text-lg">
                        @if($employee->status->value === 'active')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Đang làm việc</span>
                        @elseif($employee->status->value === 'inactive')
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Không hoạt động</span>
                        @elseif($employee->status->value === 'resigned')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Đã nghỉ</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">{{ $employee->status->value }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <i class="fas fa-info-circle text-3xl text-gray-400 mb-4"></i>
        <p class="text-gray-600">Tài khoản này chưa được liên kết với thông tin nhân viên.</p>
    </div>
    @endif
</div>
@endsection
