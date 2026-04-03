@extends('layouts.hrm')

@section('title', 'Chỉnh sửa phòng ban')

@section('page-title', 'Chỉnh sửa phòng ban')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('management.departments.update', $department) }}">
            @csrf
            @method('PUT')

            <!-- Department Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Tên phòng ban <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $department->name) }}"
                    placeholder="Nhập tên phòng ban"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Nhập mô tả phòng ban"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                >{{ old('description', $department->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Manager -->
            <div class="mb-6">
                <label for="manager_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Quản lý phòng ban
                </label>
                <select
                    name="manager_id"
                    id="manager_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('manager_id') border-red-500 @enderror"
                >
                    <option value="">-- Chọn quản lý --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('manager_id', $department->manager_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }} ({{ $employee->employee_code }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500"><i class="fas fa-info-circle mr-1"></i>Chỉ hiển thị nhân viên thuộc phòng ban này</p>
                @error('manager_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8">
                <a
                    href="{{ route('management.departments.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Hủy
                </a>
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
