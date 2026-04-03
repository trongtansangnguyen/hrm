@extends('layouts.hrm')

@section('title', 'Chi tiết Ứng viên')
@section('page-title', 'Thông tin chi tiết: ' . $candidate->full_name)

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h3 class="text-xl font-bold text-gray-800">Hồ sơ: {{ $candidate->full_name }}</h3>
        <a href="{{ route('management.candidates.index') }}" class="text-sm text-blue-600 hover:underline">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-l-4 border-blue-500 pl-2">Thông tin cá nhân</h4>
            <div class="grid grid-cols-3 gap-2 text-sm">
                <span class="text-gray-500">Họ và tên:</span>
                <span class="col-span-2 font-medium">{{ $candidate->last_name }} {{ $candidate->first_name }}</span>
                
                <span class="text-gray-500">Email:</span>
                <span class="col-span-2 font-medium">{{ $candidate->email }}</span>
                
                <span class="text-gray-500">Số điện thoại:</span>
                <span class="col-span-2 font-medium">{{ $candidate->phone }}</span>
            </div>
        </div>

        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-l-4 border-green-500 pl-2">Vị trí ứng tuyển</h4>
            <div class="grid grid-cols-3 gap-2 text-sm">
                <span class="text-gray-500">Vị trí:</span>
                <span class="col-span-2 font-medium">{{ $candidate->jobPosition->title ?? 'N/A' }}</span>
                
                <span class="text-gray-500">Trạng thái:</span>
                <span class="col-span-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                        {{ $candidate->status->label() }}
                    </span>
                </span>

                <span class="text-gray-500">Hồ sơ CV:</span>
                <span class="col-span-2">
                    @if($candidate->cv_path)
                        <a href="{{ asset('storage/' . $candidate->cv_path) }}" target="_blank" class="text-blue-500 hover:underline">
                            <i class="fas fa-download"></i> Tải xuống CV
                        </a>
                    @else
                        <span class="text-gray-400">Chưa cập nhật CV</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    @if($candidate->notes)
    <div class="mt-8">
        <h4 class="font-semibold text-gray-700 mb-2">Ghi chú/Đánh giá:</h4>
        <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-600 italic">
            "{{ $candidate->notes }}"
        </div>
    </div>
    @endif
</div>
@endsection