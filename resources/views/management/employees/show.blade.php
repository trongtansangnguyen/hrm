@extends('layouts.hrm')

@section('title', 'Chi tiết nhân viên')
@section('page-title', 'Chi tiết nhân viên')

@php
    $statusLabel = [
        1 => ['label' => 'Đang làm việc', 'class' => 'bg-green-100 text-green-800'],
        2 => ['label' => 'Đã nghỉ', 'class' => 'bg-gray-100 text-gray-700'],
        3 => ['label' => 'Tạm dừng', 'class' => 'bg-yellow-100 text-yellow-800'],
    ];

    $genderLabel = [
        0 => 'Nam',
        1 => 'Nữ',
        2 => 'Khác',
    ];
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 text-white">
            <div class="flex items-center justify-between gap-6">
                <div>
                    <div class="text-sm text-blue-100 mb-2">Mã nhân viên: {{ $employee->employee_code }}</div>
                    <h3 class="text-3xl font-bold mb-3">{{ $employee->full_name }}</h3>
                    <div class="space-y-1 text-blue-50 text-sm">
                        <p><i class="fas fa-envelope mr-2"></i>{{ $employee->email }}</p>
                        <p><i class="fas fa-phone mr-2"></i>{{ $employee->phone ?? '-' }}</p>
                    </div>
                </div>
                <div class="text-7xl opacity-20">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Họ tên</label>
                    <p class="text-gray-900 font-medium">{{ $employee->full_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <p class="text-gray-900 font-medium">{{ $employee->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Mã nhân viên</label>
                    <p class="text-gray-900 font-medium">{{ $employee->employee_code }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Số điện thoại</label>
                    <p class="text-gray-900 font-medium">{{ $employee->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Giới tính</label>
                    <p class="text-gray-900 font-medium">{{ $genderLabel[$employee->gender->value ?? 0] ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Trạng thái</label>
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusLabel[$employee->status->value ?? 0]['class'] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $statusLabel[$employee->status->value ?? 0]['label'] ?? '-' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Phòng ban</label>
                    <p class="text-gray-900 font-medium">{{ $employee->department?->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Ngày vào làm</label>
                    <p class="text-gray-900 font-medium">{{ $employee->join_date?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Địa chỉ</label>
                    <p class="text-gray-900 font-medium">{{ $employee->address ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t flex items-center justify-end gap-3">
                <a href="{{ route('management.employees.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a href="{{ route('management.employees.edit', $employee) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                </a>
                <button type="button" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-2"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>
@endsection