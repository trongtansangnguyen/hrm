@extends('layouts.hrm')

@section('title', 'Danh sách nhân viên')
@section('page-title', 'Danh sách nhân viên')

@php
    $statusLabel = [
        1 => 'Đang làm việc',
        2 => 'Đã nghỉ',
        3 => 'Tạm dừng',
        4 => 'Trong ca làm',
    ];

    $genderLabel = [
        0 => 'Nam',
        1 => 'Nữ',
        2 => 'Khác',
    ];
@endphp

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-4 md:p-6">
        <form method="GET" action="{{ route('management.employees.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Mã NV, họ tên, email..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Phòng ban</label>
                    <select
                        name="department_id"
                        id="department_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ ($filters['department_id'] ?? '') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($statusLabel as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['status'] ?? '') === (string)$value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <div class="flex gap-2 w-full">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Áp dụng
                        </button>
                        <a href="{{ route('management.employees.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                            Xóa lọc
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex flex-wrap items-center justify-end gap-2">
            <a href="{{ route('management.employees.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Thêm mới
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">STT</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã NV</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Họ tên</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SĐT</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giới tính</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phòng ban</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày vào làm</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->employee_code }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->full_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $genderLabel[$employee->gender->value ?? 0] ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->department?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $employee->join_date?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $statusLabel[$employee->status->value ?? 0] ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('management.employees.show', $employee) }}" class="px-2 py-1 bg-sky-100 text-sky-700 rounded hover:bg-sky-200" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('management.employees.edit', $employee) }}" class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Sửa">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('management.employees.destroy', $employee) }}" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-gray-500">Không có dữ liệu nhân viên.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('layouts.pagination', [
            'paginator' => $employees,
            'route' => route('management.employees.index'),
            'filters' => $filters ?? []
        ])
    </div>

</div>
@endsection
