@extends('layouts.hrm')

@section('title', 'Chấm công của tôi')
@section('page-title', 'Chấm công của tôi')

@php
    $statusMeta = [
        1 => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Đúng giờ', 'icon' => 'fa-circle-check'],
        2 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Đi trễ', 'icon' => 'fa-clock'],
        3 => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Vắng mặt', 'icon' => 'fa-circle-xmark'],
    ];

    $todayStatus = $todayAttendance?->status?->value ?? 3;
    $todayMeta = $statusMeta[$todayStatus] ?? $statusMeta[3];
@endphp

@section('content')
<div class="space-y-6">
    @if (!$employee?->id)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-triangle-exclamation text-amber-600"></i>
            <p class="text-amber-800 font-medium">Tài khoản chưa liên kết hồ sơ nhân viên, chưa thể chấm công.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5 lg:col-span-2">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Chấm công hôm nay</h3>
                    <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <div class="rounded-lg bg-blue-50 border border-blue-100 p-3">
                        <div class="text-xs text-gray-600 mb-1">Check-in</div>
                        <div class="text-base font-semibold text-gray-800">
                            {{ $todayAttendance?->check_in?->format('H:i:s') ?? '--:--:--' }}
                        </div>
                    </div>
                    <div class="rounded-lg bg-purple-50 border border-purple-100 p-3">
                        <div class="text-xs text-gray-600 mb-1">Check-out</div>
                        <div class="text-base font-semibold text-gray-800">
                            {{ $todayAttendance?->check_out?->format('H:i:s') ?? '--:--:--' }}
                        </div>
                    </div>
                    <div class="rounded-lg bg-emerald-50 border border-emerald-100 p-3">
                        <div class="text-xs text-gray-600 mb-1">Tổng giờ làm</div>
                        <div class="text-base font-semibold text-gray-800">
                            {{ number_format((float) ($todayAttendance?->working_hours ?? 0), 2) }} giờ
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3">
                    @if($canCheckIn)
                        <form method="POST" action="{{ route('employee-attendances.check-in') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                <i class="fas fa-right-to-bracket mr-2"></i> Check-in
                            </button>
                        </form>
                    @endif

                    @if($canCheckOut)
                        <form method="POST" action="{{ route('employee-attendances.check-out') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                <i class="fas fa-right-from-bracket mr-2"></i> Check-out
                            </button>
                        </form>
                    @endif

                    @if(!$canCheckIn && !$canCheckOut)
                        <p class="text-sm text-gray-600">Bạn đã hoàn tất chấm công hôm nay.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="text-sm text-gray-500 mb-2">Trạng thái hôm nay</div>
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold {{ $todayMeta['bg'] }} {{ $todayMeta['text'] }}">
                    <i class="fas {{ $todayMeta['icon'] }}"></i>
                    {{ $todayMeta['label'] }}
                </span>
                <div class="mt-4 text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Nhân viên:</span> {{ $employee->full_name }}</p>
                    <p><span class="font-medium">Phòng ban:</span> {{ $employee->department?->name ?? 'Chưa gán' }}</p>
                </div>
                <div class="mt-4 p-3 rounded-lg bg-gray-50 border border-gray-100 text-xs text-gray-600">
                    Mốc đánh giá đi trễ: sau {{ config('attendance.standard_start_time', '08:30') }}.
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span>Lịch sử chấm công</span>
            </div>
            @if($employee?->id)
                <span class="text-sm text-gray-600">Tổng: {{ $attendances->total() }} bản ghi</span>
            @endif
        </div>

        <div class="md:hidden divide-y divide-gray-100">
            @forelse($employee?->id ? $attendances : collect() as $attendance)
                @php
                    $meta = $statusMeta[$attendance->status->value] ?? $statusMeta[3];
                @endphp
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-xs text-gray-500">Ngày</div>
                            <div class="text-sm font-semibold text-gray-800">{{ $attendance->date?->format('d/m/Y') }}</div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
                            <i class="fas {{ $meta['icon'] }}"></i>
                            {{ $meta['label'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <div class="text-xs text-gray-500">Check-in</div>
                            <div class="font-medium text-gray-700">{{ $attendance->check_in?->format('H:i:s') ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Check-out</div>
                            <div class="font-medium text-gray-700">{{ $attendance->check_out?->format('H:i:s') ?? '-' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Giờ làm</div>
                        <div class="text-sm font-medium text-gray-700">{{ number_format((float) $attendance->working_hours, 2) }} giờ</div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-3 text-gray-300"></i>
                    <p class="text-base">Chưa có dữ liệu chấm công</p>
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-out</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giờ làm</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employee?->id ? $attendances : collect() as $attendance)
                        @php
                            $meta = $statusMeta[$attendance->status->value] ?? $statusMeta[3];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $attendance->date?->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $attendance->check_in?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $attendance->check_out?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ number_format((float) $attendance->working_hours, 2) }} giờ</td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
                                    <i class="fas {{ $meta['icon'] }}"></i>
                                    {{ $meta['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-3 text-gray-300"></i>
                                <p class="text-base">Chưa có dữ liệu chấm công</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employee?->id && method_exists($attendances, 'links'))
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $attendances->links('layouts.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
