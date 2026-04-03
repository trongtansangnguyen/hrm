@extends('layouts.hrm')

@section('title', 'Chỉnh sửa nhân viên')
@section('page-title', 'Chỉnh sửa nhân viên')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Chỉnh sửa nhân viên</h3>
                <p class="text-sm text-gray-500 mt-1">Giao diện form, chưa gắn xử lý cập nhật.</p>
            </div>
            <a href="{{ route('management.employees.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>

        <form method="POST" action="{{ route('management.employees.update', $employee) }}">
            @csrf
            @method('PUT')
            @include('management.employees._form', ['employee' => $employee])

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('management.employees.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Hủy
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection