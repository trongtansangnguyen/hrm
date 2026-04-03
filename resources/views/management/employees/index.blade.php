@extends('layouts.hrm')

@section('title', 'Danh sách nhân viên')
@section('page-title', 'Danh sách nhân viên')

@php
    $statusLabel = [
        1 => 'Đang làm việc',
        2 => 'Đã nghỉ',
        3 => 'Tạm dừng',
    ];

    $genderLabel = [
        0 => 'Nam',
        1 => 'Nữ',
        2 => 'Khác',
    ];
@endphp

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-2">
        <div class="text-sm text-gray-600"></div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('management.employees.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Thêm mới
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
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
@endsection
