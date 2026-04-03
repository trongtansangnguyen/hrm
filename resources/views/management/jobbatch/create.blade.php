@extends('layouts.hrm')
@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Thêm Vị trí Tuyển dụng Mới</h2>
    <form action="{{ route('management.jobbatch.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Tên vị trí:</label>
            <input type="text" name="title" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Phòng ban:</label>
            <select name="department_id" class="border p-2 w-full">
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Trạng thái:</label>
            <select name="status" class="border p-2 w-full">
                <option value="1" {{ $job->status == 1 ? 'selected' : '' }}>Đang tuyển</option>
                <option value="0" {{ $job->status == 0 ? 'selected' : '' }}>Đóng</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu lại</button>
    </form>
</div>
@endsection