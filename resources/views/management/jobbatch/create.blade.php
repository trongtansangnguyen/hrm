@extends('layouts.hrm')
@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Thêm Vị trí Tuyển dụng Mới</h2>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('management.jobbatch.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Tên vị trí:</label>
            <input type="text" name="title" value="{{ old('title') }}" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Phòng ban:</label>
            <select name="department_id" class="border p-2 w-full">
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Mô tả:</label>
            <textarea name="description" class="border p-2 w-full" rows="4">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label>Trạng thái:</label>
            <select name="status" class="border p-2 w-full">
                <option value="1" {{ (int) old('status', 1) === 1 ? 'selected' : '' }}>Đang tuyển</option>
                <option value="2" {{ (int) old('status') === 2 ? 'selected' : '' }}>Đóng</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu lại</button>
    </form>
</div>
@endsection