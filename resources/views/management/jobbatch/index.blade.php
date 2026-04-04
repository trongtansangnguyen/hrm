@extends('layouts.hrm')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Quản lý Vị trí Tuyển dụng</h2>
        <a href="{{ route('management.jobbatch.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + Thêm Job mới
        </a>
    </div>

    <form method="GET" action="{{ route('management.jobbatch.index') }}" class="mb-6 grid grid-cols-1 gap-3 md:grid-cols-5">
        <input
            type="text"
            name="search"
            value="{{ $filters['search'] ?? '' }}"
            placeholder="Tìm vị trí, mô tả..."
            class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
        >

        <select name="department_id" class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Tất cả phòng ban</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ (string) ($filters['department_id'] ?? '') === (string) $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Tất cả trạng thái</option>
            <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Đang tuyển</option>
            <option value="2" {{ ($filters['status'] ?? '') === '2' ? 'selected' : '' }}>Đóng</option>
        </select>

        <select name="per_page" class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="10" {{ ($filters['per_page'] ?? 10) == 10 ? 'selected' : '' }}>10/trang</option>
            <option value="20" {{ ($filters['per_page'] ?? 10) == 20 ? 'selected' : '' }}>20/trang</option>
            <option value="50" {{ ($filters['per_page'] ?? 10) == 50 ? 'selected' : '' }}>50/trang</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700">
                Lọc
            </button>
            <a href="{{ route('management.jobbatch.index') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">
                Xóa lọc
            </a>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">STT</th>
                    <th class="px-6 py-4">Tên Vị Trí</th>
                    <th class="px-6 py-4">Phòng Ban</th>
                    <th class="px-6 py-4">Ứng Viên</th>
                    <th class="px-6 py-4">Trạng Thái</th>
                    <th class="px-6 py-4">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($jobs as $job)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-700">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium text-slate-700">{{ $job->title }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $job->department->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $job->candidates->count() }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs {{ $job->status == 1 ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                            {{ $job->status == 1 ? 'Đang tuyển' : 'Đóng' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-3">
                        <a href="{{ route('management.jobbatch.show', $job->id) }}" class="text-slate-600 hover:text-slate-900">Chi tiết</a>
                        <a href="{{ route('management.jobbatch.edit', $job->id) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                        <form action="{{ route('management.jobbatch.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa?')">
                            @csrf @method('DELETE')
                            <button class="text-rose-600 hover:text-rose-900">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-slate-500 text-sm">Chưa có vị trí tuyển dụng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-slate-600">
            Hiển thị <span class="font-semibold">{{ ($jobs->currentPage() - 1) * $jobs->perPage() + 1 }}</span> đến
            <span class="font-semibold">{{ min($jobs->currentPage() * $jobs->perPage(), $jobs->total()) }}</span>
            trong <span class="font-semibold">{{ $jobs->total() }}</span> vị trí
        </div>
        <div>
            {{ $jobs->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection