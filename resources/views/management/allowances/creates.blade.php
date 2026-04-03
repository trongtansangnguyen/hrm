@extends('layouts.hrm')

@section('title', 'Thêm Loại Phụ Cấp')
@section('page-title', 'Thêm Loại Phụ Cấp Mới')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('management.allowances.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tên loại phụ cấp</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="VD: Phụ cấp ăn trưa" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Số tiền mặc định (VNĐ)</label>
                <input type="number" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="500000" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('management.allowances.indexs') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu lại</button>
        </div>
    </form>
</div>
@endsection