@extends('layouts.hrm')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Quản lý Vị trí Tuyển dụng</h2>
        <a href="{{ route('management.jobbatch.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Thêm Job mới
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Tên Vị Trí</th>
                    <th class="px-6 py-4">Phòng Ban</th>
                    <th class="px-6 py-4">Trạng Thái</th>
                    <th class="px-6 py-4">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($jobs as $job)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-700">{{ $job->title }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $job->department->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs {{ $job->status == 1 ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                            {{ $job->status == 1 ? 'Đang tuyển' : 'Đóng' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-3">
                        <a href="{{ route('management.jobbatch.edit', $job->id) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                        <form action="{{ route('management.jobbatch.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa?')">
                            @csrf @method('DELETE')
                            <button class="text-rose-600 hover:text-rose-900">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection