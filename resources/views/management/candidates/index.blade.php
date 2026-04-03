@extends('layouts.hrm')

@section('title', 'Quản lý Ứng viên')
@section('page-title', 'Danh sách Ứng viên')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Hồ sơ ứng tuyển</h3>
        {{-- Nút này có thể dẫn đến form tạo ứng viên thủ công nếu cần --}}
        <button onclick="alert('Chức năng đang phát triển')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-user-plus"></i> Thêm ứng viên
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 text-sm font-semibold text-gray-600">Tên Ứng Viên</th>
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
                    <td class="p-3">
                        <div class="text-sm font-medium text-gray-900">{{ $candidate->full_name }}</div>
                        <div class="text-xs text-gray-500">{{ $candidate->email }} | {{ $candidate->phone }}</div>
                    </td>
                    <td class="p-3 text-sm text-gray-700">
                        {{-- Giả sử bạn có quan hệ jobPosition trong Model --}}
                        {{ $candidate->jobPosition->name ?? 'N/A' }}
                    </td>
                    <td class="p-3">
                        @php
                            $statusClasses = [
                                'applied' => 'bg-blue-100 text-blue-700',
                                'interview' => 'bg-yellow-100 text-yellow-700',
                                'hired' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'applied' => 'Mới ứng tuyển',
                                'interview' => 'Phỏng vấn',
                                'hired' => 'Đã tuyển',
                                'rejected' => 'Đã loại',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$candidate->status] ?? 'bg-gray-100' }}">
                            {{ $statusLabels[$candidate->status] ?? $candidate->status }}
                        </span>
                    </td>
                    <td class="p-3 text-sm">
                        @if($candidate->CV_path)
                            <a href="{{ asset('storage/' . $candidate->CV_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-file-pdf"></i> Xem CV
                            </a>
                        @else
                            <span class="text-gray-400">Không có</span>
                        @endif
                    </td>
                    <td class="p-3 text-right">
                        <div class="flex justify-end gap-2">
                            {{-- Dropdown nhanh để đổi trạng thái --}}
                            <form action="{{ route('management.candidates.updateStatus', $candidate->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-md focus:ring-blue-500">
                                    <option value="applied" {{ $candidate->status == 'applied' ? 'selected' : '' }}>Mới nhận</option>
                                    <option value="interview" {{ $candidate->status == 'interview' ? 'selected' : '' }}>Phỏng vấn</option>
                                    <option value="hired" {{ $candidate->status == 'hired' ? 'selected' : '' }}>Tuyển dụng</option>
                                    <option value="rejected" {{ $candidate->status == 'rejected' ? 'selected' : '' }}>Loại</option>
                                </select>
                            </form>
                            <a href="{{ route('management.candidates.show', $candidate->id) }}" class="p-2 text-gray-400 hover:text-blue-600">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 text-sm">Chưa có hồ sơ ứng viên nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $candidates->links() }}
    </div>
</div>
@endsection