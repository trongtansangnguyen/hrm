@extends('layouts.hrm')

@section('content')
<h2 class="text-2xl font-bold mb-4">Sửa Vị trí Tuyển dụng</h2>

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('management.jobbatch.update', ['jobId' => $job->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Tên vị trí:</label>
        <input type="text" name="title"
               value="{{ old('title', $job->title) }}"
               class="border p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label>Phòng ban:</label>
        <select name="department_id" class="border p-2 w-full">
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}"
                    {{ (int) old('department_id', $job->department_id) === $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Mô tả:</label>
        <textarea name="description" class="border p-2 w-full" rows="4">{{ old('description', $job->description) }}</textarea>
    </div>

    <div class="mb-4">
        <label>Trạng thái:</label>
        <select name="status" class="border p-2 w-full">
            <option value="1" {{ (int) old('status', $job->status) === 1 ? 'selected' : '' }}>Đang tuyển</option>
            <option value="2" {{ (int) old('status', $job->status) === 2 ? 'selected' : '' }}>Đóng</option>
        </select>
    </div>

    <div class="flex justify-between items-center mt-6">
    <a href="{{ route('management.jobbatch.index') }}"
       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
        ← Quay lại
    </a>

    <button type="submit"
            class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
        Cập nhật
    </button>
</div>
</form>
@endsection