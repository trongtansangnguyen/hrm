@extends('layouts.hrm')

@section('title', 'Dashboard - SGU Tech Hub')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Employees -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Tổng nhân viên</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $data['employee_summary']['total_employees'] ?? 0 }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Active Employees -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Đang làm việc</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $data['employee_summary']['working_employees'] ?? 0 }}</h3>
                <p class="text-xs text-green-600 mt-2">
                    <i class="fas fa-check"></i> {{ $data['employee_summary']['working_percentage'] ?? 0 }}% tỷ lệ
                </p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- On Leave -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Nghỉ phép hôm nay</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $data['leave_summary']['total_leave_requests_today'] ?? 0 }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-calendar"></i> {{ $data['leave_summary']['total_approved_leave_requests_this_month'] ?? 0 }} đã duyệt trong tháng này
                </p>
            </div>
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-times text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>

    <!-- New Candidates -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Ứng viên mới</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $data['candidate_summary']['new_candidates'] ?? 0 }}</h3>
                <p class="text-xs text-blue-600 mt-2">
                    <i class="fas fa-clock"></i> {{ $data['candidate_summary']['applied_candidates'] ?? 0 }} chờ phỏng vấn
                </p>
            </div>
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-2xl text-red-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Activities -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Recent Activities -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-chart-line text-blue-600"></i> Hoạt động gần đây
            </h3>
        </div>
        <div class="space-y-4">
            @forelse($data['recent_activities'] as $activity)
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $activity['action'] === 'create' ? 'bg-blue-100' : ($activity['action'] === 'update' ? 'bg-yellow-100' : 'bg-red-100') }}">
                        <i class="fas {{ $activity['action'] === 'create' ? 'fa-user-plus text-blue-600' : ($activity['action'] === 'update' ? 'fa-edit text-yellow-600' : 'fa-trash text-red-600') }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">
                            {{ ucfirst($activity['action']) }} {{ str_replace('_', ' ', $activity['table_name']) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity['user_name'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $activity['created_at']->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2 opacity-30"></i>
                    <p>Chưa có hoạt động</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-chart-pie text-blue-300"></i> Thống kê hoạt động
        </h3>
        <div class="space-y-4">
            @forelse($data['department_stats'] as $dept)
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 font-medium">{{ $dept['name'] }}</span>
                        <span class="font-semibold text-gray-800">{{ $dept['working_employees'] }}/{{ $dept['total_employees'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: {{ $dept['percentage'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $dept['percentage'] }}% hoạt động</p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p>Chưa có phòng ban</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@can('is-admin-or-manager')
<!-- Quick Actions For Manager -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <button onclick="alert('Chức năng đang phát triển')" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all hover:-translate-y-1 text-center group">
        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
            <i class="fas fa-user-plus text-3xl text-blue-600 group-hover:text-white"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Thêm nhân viên</h4>
        <p class="text-xs text-gray-500 mt-2">Tạo hồ sơ nhân viên mới</p>
    </button>

    <button onclick="alert('Chức năng đang phát triển')" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all hover:-translate-y-1 text-center group">
        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
            <i class="fas fa-clock text-3xl text-green-600 group-hover:text-white"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Chấm công</h4>
        <p class="text-xs text-gray-500 mt-2">Điểm danh hôm nay</p>
    </button>

    <button onclick="alert('Chức năng đang phát triển')" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all hover:-translate-y-1 text-center group">
        <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 transition-colors">
            <i class="fas fa-money-check-alt text-3xl text-orange-600 group-hover:text-white"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Tính lương</h4>
        <p class="text-xs text-gray-500 mt-2">Xử lý bảng lương</p>
    </button>

    <button onclick="alert('Chức năng đang phát triển')" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all hover:-translate-y-1 text-center group">
        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
            <i class="fas fa-file-alt text-3xl text-purple-600 group-hover:text-white"></i>
        </div>
        <h4 class="font-semibold text-gray-800">Báo cáo</h4>
        <p class="text-xs text-gray-500 mt-2">Xem báo cáo chi tiết</p>
    </button>
</div>
@endcan
@endsection