@extends('layouts.hrm')

@section('title', 'Theo dõi chấm công')
@section('page-title', 'Theo dõi chấm công')

@php
    $statusColors = [
        1 => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Đúng giờ', 'icon' => 'fa-circle-check'],
        2 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Đi trễ', 'icon' => 'fa-clock'],
        3 => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Vắng mặt', 'icon' => 'fa-circle-xmark'],
    ];
@endphp

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('management.attendances.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            <input
                type="date"
                name="date"
                value="{{ $filters['date'] ?? '' }}"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm"
            >

            <select name="department_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Tất cả phòng ban</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ (string) ($filters['department_id'] ?? '') === (string) $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>

            <input
                type="text"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Mã NV / Họ tên"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm"
            >

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Lọc</button>
                <a href="{{ route('management.attendances.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Xóa lọc</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">STT</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nhân viên</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phòng ban</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-in</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check-out</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giờ làm</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                        @php
                            $meta = $statusColors[$attendance->status->value] ?? $statusColors[3];
                        @endphp
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $attendances->firstItem() ? $attendances->firstItem() + $loop->index : $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $attendance->date?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $attendance->employee?->full_name ?? '-' }}
                                <div class="text-xs text-gray-500">{{ $attendance->employee?->employee_code ?? '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $attendance->employee?->department?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $attendance->check_in?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $attendance->check_out?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ number_format((float) $attendance->working_hours, 2) }} giờ</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
                                    <i class="fas {{ $meta['icon'] }}"></i>
                                    {{ $meta['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-500">Không có dữ liệu chấm công phù hợp bộ lọc.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($attendances, 'links'))
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $attendances->links('layouts.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
