@extends('layouts.hrm')

@section('title', 'Sửa Loại Phụ cấp')
@section('page-title', 'Chỉnh sửa Loại Phụ cấp')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
         Sửa Loại Phụ cấp
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('management.allowances.update', $allowance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label class="block font-semibold text-gray-700 mb-2">
                Tên loại phụ cấp
            </label>
            <input type="text" name="name"
                   value="{{ old('name', $allowance->name) }}"
                   class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400"
                   placeholder="Nhập tên loại..."
                   required>
        </div>

        
        <div class="mb-6">
            <label class="block font-semibold text-gray-700 mb-2">
                Số tiền mặc định (VNĐ)
            </label>
            <input type="number" name="amount"
                   value="{{ old('amount', $allowance->amount) }}"
                   class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400"
                   placeholder="Nhập số tiền..."
                   min="0"
                   required>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('management.allowances.index') }}"
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                ← Quay lại
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
                 Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection