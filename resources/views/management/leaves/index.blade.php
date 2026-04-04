@extends('layouts.hrm')

@section('title', 'Quản lý nghỉ phép')
@section('page-title', 'Quản lý nghỉ phép')

@php
	$statusColors = [
		1 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Chờ duyệt', 'icon' => 'fa-clock'],
		2 => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Đã duyệt', 'icon' => 'fa-circle-check'],
		3 => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Từ chối', 'icon' => 'fa-circle-xmark'],
	];
@endphp

@section('content')
<div class="space-y-6">
	<div class="text-sm text-gray-600">Theo dõi và xử lý đơn nghỉ phép của nhân viên.</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
		<div class="bg-white rounded-xl shadow-sm p-5">
			<p class="text-sm text-gray-600">Đang nghỉ hôm nay</p>
			<p class="text-3xl font-bold text-gray-800 mt-1">{{ $summary['active_today'] ?? 0 }}</p>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5">
			<p class="text-sm text-gray-600">Đã duyệt</p>
			<p class="text-3xl font-bold text-green-700 mt-1">{{ $summary['approved'] ?? 0 }}</p>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5">
			<p class="text-sm text-gray-600">Chờ duyệt</p>
			<p class="text-3xl font-bold text-yellow-700 mt-1">{{ $summary['pending'] ?? 0 }}</p>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5">
			<p class="text-sm text-gray-600">Từ chối</p>
			<p class="text-3xl font-bold text-red-700 mt-1">{{ $summary['rejected'] ?? 0 }}</p>
		</div>
	</div>

	<div class="bg-white rounded-xl shadow-sm p-4">
		<form method="GET" action="{{ route('management.leaves.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
			<input
				type="text"
				name="search"
				value="{{ $filters['search'] ?? '' }}"
				placeholder="Mã NV / Tên nhân viên"
				class="px-3 py-2 border border-gray-300 rounded-lg text-sm"
			>

			<select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
				<option value="">Tất cả trạng thái</option>
				<option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Chờ duyệt</option>
				<option value="2" {{ ($filters['status'] ?? '') === '2' ? 'selected' : '' }}>Đã duyệt</option>
				<option value="3" {{ ($filters['status'] ?? '') === '3' ? 'selected' : '' }}>Từ chối</option>
			</select>

			<input type="date" name="from_date" value="{{ $filters['from_date'] ?? '' }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
			<input type="date" name="to_date" value="{{ $filters['to_date'] ?? '' }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">

			<div class="flex gap-2">
				<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Lọc</button>
				<a href="{{ route('management.leaves.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">Xóa lọc</a>
			</div>
		</form>
	</div>

	<div class="bg-white rounded-xl shadow-sm overflow-hidden">
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">STT</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nhân viên</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phòng ban</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Từ ngày</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đến ngày</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lý do</th>
						<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Người duyệt</th>
						<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Thao tác</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@forelse($leaveRequests as $leave)
						@php
							$meta = $statusColors[$leave->status->value] ?? $statusColors[1];
						@endphp
						<tr>
							<td class="px-4 py-3 text-sm text-gray-900">{{ $loop->iteration }}</td>
							<td class="px-4 py-3 text-sm text-gray-900">

								{{ $leave->employee?->full_name ?? '-' }}
								<div class="text-xs text-gray-500">{{ $leave->employee?->employee_code ?? '' }}</div>
							</td>
							<td class="px-4 py-3 text-sm text-gray-700">{{ $leave->employee?->department?->name ?? '-' }}</td>
							<td class="px-4 py-3 text-sm text-gray-700">{{ $leave->from_date?->format('d/m/Y') }}</td>
							<td class="px-4 py-3 text-sm text-gray-700">{{ $leave->to_date?->format('d/m/Y') }}</td>
							<td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $leave->reason }}</td>
							<td class="px-4 py-3 text-center">
								<span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
									<i class="fas {{ $meta['icon'] }}"></i>
									{{ $meta['label'] }}
								</span>
							</td>
							<td class="px-4 py-3 text-sm text-gray-700">{{ $leave->approver?->email ?? '-' }}</td>
							<td class="px-4 py-3 text-center">
								@if($leave->status->value === 1)
									<div class="inline-flex items-center gap-2">
										<form method="POST" action="{{ route('management.leaves.approve', $leave) }}">
											@csrf
											@method('PATCH')
											<button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-full text-sm font-semibold border border-green-700 leading-none">
												<i class="fas fa-check-circle"></i>
												<span>Duyệt</span>
											</button>
										</form>
										<form method="POST" action="{{ route('management.leaves.reject', $leave) }}">
											@csrf
											@method('PATCH')
											<button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white rounded-full text-sm font-semibold border border-red-700 leading-none">
												<i class="fas fa-ban"></i>
												<span>Từ chối</span>
											</button>
										</form>
									</div>
								@else
									<span class="text-xs text-gray-400">-</span>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="8" class="px-4 py-10 text-center text-gray-500">Chưa có đơn nghỉ phù hợp bộ lọc.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@if(method_exists($leaveRequests, 'links'))
			<div class="px-4 py-3 border-t border-gray-100">
				{{ $leaveRequests->links('layouts.pagination') }}
			</div>
		@endif
	</div>
</div>
@endsection
