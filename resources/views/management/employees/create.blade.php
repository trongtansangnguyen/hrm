@extends('layouts.hrm')

@section('title', 'Tạo nhân viên mới')
@section('page-title', 'Tạo nhân viên mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Tạo nhân viên mới</h3>
                <p class="text-sm text-gray-500 mt-1">Mã nhân viên sẽ được tạo tự động theo id sau khi lưu.</p>
            </div>
            <a href="{{ route('management.employees.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>

        <form method="POST" action="{{ route('management.employees.store') }}">
            @csrf
            @include('management.employees._form', ['employee' => null])

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('management.employees.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Hủy
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Tạo mới
                </button>
            </div>
        </form>
    </div>
</div>
@endsection