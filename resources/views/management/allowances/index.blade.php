@extends('layouts.hrm')

@section('title', 'Quản lý Phụ cấp')
@section('page-title', 'Danh sách Phụ cấp')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Thông tin phụ cấp nhân viên</h3>
        <a href="{{ route('management.allowances.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="p-3 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Nhân viên</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Loại phụ cấp</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Số tiền</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-3 text-sm text-gray-500" colspan="5 text-center">Chưa có dữ liệu hiển thị.</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection