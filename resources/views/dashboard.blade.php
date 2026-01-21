@extends('layouts.hrm')

@section('title', 'Dashboard - HRM System')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Employees -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Tổng nhân viên</p>
                <h3 class="text-3xl font-bold text-gray-800">248</h3>
                <p class="text-xs text-green-600 mt-2">
                    <i class="fas fa-arrow-up"></i> +12% so với tháng trước
                </p>
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
                <h3 class="text-3xl font-bold text-gray-800">235</h3>
                <p class="text-xs text-green-600 mt-2">
                    <i class="fas fa-check"></i> 94.8% tỷ lệ
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
                <h3 class="text-3xl font-bold text-gray-800">13</h3>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-calendar"></i> 5 đã duyệt
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
                <h3 class="text-3xl font-bold text-gray-800">42</h3>
                <p class="text-xs text-blue-600 mt-2">
                    <i class="fas fa-clock"></i> 8 chờ phỏng vấn
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
            <button class="text-sm text-blue-600 hover:text-blue-700">Xem tất cả</button>
        </div>
        <div class="space-y-4">
            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">Nhân viên mới được thêm</p>
                    <p class="text-xs text-gray-500 mt-1">Nguyễn Văn A đã được thêm vào phòng IT</p>
                    <p class="text-xs text-gray-400 mt-1">2 giờ trước</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">Đơn nghỉ phép được duyệt</p>
                    <p class="text-xs text-gray-500 mt-1">Trần Thị B - Nghỉ phép 3 ngày</p>
                    <p class="text-xs text-gray-400 mt-1">5 giờ trước</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-orange-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">Bảng lương tháng 1 đã được tạo</p>
                    <p class="text-xs text-gray-500 mt-1">235 nhân viên</p>
                    <p class="text-xs text-gray-400 mt-1">1 ngày trước</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-chart-pie text-purple-600"></i> Thống kê nhanh
        </h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Phòng IT</span>
                    <span class="font-semibold text-gray-800">45/50</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Phòng Sale</span>
                    <span class="font-semibold text-gray-800">38/40</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 95%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Phòng Marketing</span>
                    <span class="font-semibold text-gray-800">28/35</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600">Phòng HR</span>
                    <span class="font-semibold text-gray-800">12/15</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
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
@endsection