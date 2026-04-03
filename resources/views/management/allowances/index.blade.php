@extends('layouts.hrm')

@section('title', 'Quản lý Loại Phụ cấp')
@section('page-title', 'Danh sách Loại Phụ cấp')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Danh mục loại phụ cấp hệ thống</h3>
        <a href="{{ route('management.allowances.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-plus"></i> Thêm loại mới
        </a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="p-3 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Tên loại</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Số tiền mặc định</th>
                <th class="p-3 text-sm font-semibold text-gray-600">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allowances as $allowance)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-sm text-gray-700">{{ $allowance->id }}</td>
                <td class="p-3 text-sm text-gray-700 font-medium">{{ $allowance->name }}</td>
                <td class="p-3 text-sm text-gray-700">{{ number_format($allowance->amount) }} VNĐ</td>
                <td class="p-3 text-sm">
                    <a href="{{ route('management.allowances.edit', $allowance->id) }}"
                        class="text-blue-500 hover:underline mr-2">
                            Sửa
                        </a>
                    <form action="{{ route('management.allowances.destroy', $allowance->id) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td class="p-3 text-sm text-gray-500 text-center" colspan="4">Chưa có loại phụ cấp nào được tạo.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection