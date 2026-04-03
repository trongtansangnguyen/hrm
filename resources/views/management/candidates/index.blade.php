@extends('layouts.hrm')

@section('title', 'Quản lý Ứng viên')
@section('page-title', 'Danh sách Ứng viên')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Hồ sơ ứng tuyển</h3>
        {{-- Nút này có thể dẫn đến form tạo ứng viên thủ công nếu cần 
        <button onclick="alert('Chức năng đang phát triển')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-user-plus"></i> Thêm ứng viên
        </button>--}}
    </div>

    <form method="GET" action="{{ route('management.candidates.index') }}" class="mb-4 grid grid-cols-1 gap-3 md:grid-cols-4">
        <input
            type="text"
            name="search"
            value="{{ $filters['search'] ?? '' }}"
            placeholder="Tìm tên, email, SĐT, vị trí..."
            class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
        >

        <select name="department_id" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Tất cả phòng ban</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ (string) ($filters['department_id'] ?? '') === (string) $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Tất cả trạng thái</option>
            <option value="applied" {{ ($filters['status'] ?? '') === 'applied' ? 'selected' : '' }}>Mới nhận</option>
            <option value="interview" {{ ($filters['status'] ?? '') === 'interview' ? 'selected' : '' }}>Phỏng vấn</option>
            <option value="hired" {{ ($filters['status'] ?? '') === 'hired' ? 'selected' : '' }}>Tuyển dụng</option>
            <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Loại</option>
        </select>

        <select name="per_page" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="10" {{ ($filters['per_page'] ?? 10) == 10 ? 'selected' : '' }}>10/trang</option>
            <option value="20" {{ ($filters['per_page'] ?? 10) == 20 ? 'selected' : '' }}>20/trang</option>
            <option value="50" {{ ($filters['per_page'] ?? 10) == 50 ? 'selected' : '' }}>50/trang</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">Lọc</button>
            <a href="{{ route('management.candidates.index') }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Xóa lọc</a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 text-sm font-semibold text-gray-600">Tên Ứng Viên</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Phòng ban</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Vị trí</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">CV</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Trạng Thái</th>
                    <th class="p-3 text-sm font-semibold text-gray-600 text-right">Hành Động</th>
                </tr>
            </thead>
            <tbody>
    @forelse($candidates as $candidate)
    <tr class="border-b hover:bg-gray-50 transition-colors">
        {{-- 1. Tên Ứng Viên --}}
        <td class="p-3">
            <div class="text-sm font-medium text-gray-900">{{ $candidate->last_name }} {{ $candidate->first_name }}</div>
        </td>

        <td class="p-3 text-sm text-gray-700">
            {{ $candidate->jobPosition->department->name ?? 'N/A' }}
        </td>
        
        {{-- 2. Vị trí --}}
        <td class="p-3 text-sm text-gray-700">
            {{ $candidate->jobPosition->title ?? 'N/A' }}
        </td>

        {{-- 3. Email --}}
        <td class="p-3 text-sm text-gray-700">
            {{ $candidate->email }}
        </td>

        {{-- 4. CV --}}
        <td class="p-3 text-sm">
            @if($candidate->cv_path)
                <a href="{{ asset('storage/' . $candidate->cv_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                    <i class="fas fa-file-pdf"></i> Xem CV
                </a>
            @else
                <span class="text-gray-400">Không có</span>
            @endif
        </td>

        {{-- 5. Trạng Thái (Badge) --}}
        <td class="px-6 py-4">
            @php
                $statusValue = $candidate->status?->value;
                $class = '';
                $text = '';

                switch($statusValue) {
                    case 3:
                        $class = 'bg-green-100 text-green-800 border-green-200';
                        $text = 'Tuyển dụng';
                        break;
                    case 2:
                        $class = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        $text = 'Phỏng vấn';
                        break;
                    case 4:
                        $class = 'bg-red-100 text-red-800 border-red-200';
                        $text = 'Loại';
                        break;
                    default:
                        $class = 'bg-blue-100 text-blue-800 border-blue-200';
                        $text = 'Mới nhận';
                }
            @endphp

            <span class="px-2 py-1 rounded-full border text-xs font-semibold {{ $class }}">
                {{ $text }}
            </span>
        </td>

        {{-- 6. Hành Động (Gồm Select và Nút Xem) --}}
        <td class="p-3 text-right">
            <div class="flex justify-end items-center gap-3">
                <form action="{{ route('management.candidates.updateStatus', $candidate->id) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-md focus:ring-blue-500 py-1">
                        <option value="applied" {{ $candidate->status?->value === 1 ? 'selected' : '' }}>Mới nhận</option>
                        <option value="interview" {{ $candidate->status?->value === 2 ? 'selected' : '' }}>Phỏng vấn</option>
                        <option value="hired" {{ $candidate->status?->value === 3 ? 'selected' : '' }}>Tuyển dụng</option>
                        <option value="rejected" {{ $candidate->status?->value === 4 ? 'selected' : '' }}>Loại</option>
                    </select>
                </form>
                <a href="{{ route('management.candidates.show', $candidate->id) }}" class="text-gray-400 hover:text-blue-600">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="p-4 text-center text-gray-500 text-sm">Chưa có hồ sơ ứng viên nào.</td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
    
    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Hiển thị <span class="font-semibold">{{ ($candidates->currentPage() - 1) * $candidates->perPage() + 1 }}</span> đến
            <span class="font-semibold">{{ min($candidates->currentPage() * $candidates->perPage(), $candidates->total()) }}</span>
            trong <span class="font-semibold">{{ $candidates->total() }}</span> ứng viên
        </div>
        <div>
            {{ $candidates->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection