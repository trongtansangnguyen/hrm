@extends('layouts.hrm')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Chi tiết Vị trí Tuyển dụng</h2>
        <a href="{{ route('management.jobbatch.index') }}" class="rounded-lg bg-slate-200 px-4 py-2 text-slate-700 hover:bg-slate-300">
            Quay lại
        </a>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <p class="text-sm text-slate-500">Tên vị trí</p>
                <p class="font-semibold text-slate-800">{{ $job->title }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Phòng ban</p>
                <p class="font-semibold text-slate-800">{{ $job->department->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Trạng thái</p>
                <span class="inline-block rounded-full px-3 py-1 text-xs {{ $job->status == 1 ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                    {{ $job->status == 1 ? 'Đang tuyển' : 'Đóng' }}
                </span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Số ứng viên</p>
                <p class="font-semibold text-slate-800">{{ $job->candidates->count() }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-slate-500">Mô tả</p>
                <p class="whitespace-pre-line text-slate-700">{{ $job->description ?: 'Chưa có mô tả' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
