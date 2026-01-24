@extends('layouts.hrm')

@section('title', 'Nghỉ phép')
@section('page-title', 'Quản lý nghỉ phép')

@php
	// Fallback dữ liệu demo khi controller chưa truyền sang view
	$summary = $summary ?? [
		'active_today' => 5,
		'approved' => 12,
		'pending' => 4,
		'rejected' => 2,
	];

	$filters = $filters ?? [];
	$leaveTypes = $leaveTypes ?? ['Nghỉ phép năm', 'Nghỉ ốm', 'Làm việc từ xa'];

	$leaveRequests = $leaveRequests ?? [
		[
			'employee' => 'Nguyễn Văn A',
			'type' => 'Nghỉ phép năm',
			'from' => '2026-01-25',
			'to' => '2026-01-27',
			'days' => 3,
			'status' => 'approved',
			'reason' => 'Du lịch cùng gia đình',
			'approver' => 'Trưởng phòng IT',
			'created_at' => '2026-01-18 09:30',
		],
		[
			'employee' => 'Trần Thị B',
			'type' => 'Nghỉ ốm',
			'from' => '2026-01-24',
			'to' => '2026-01-24',
			'days' => 1,
			'status' => 'pending',
			'reason' => 'Ốm sốt',
			'approver' => 'HR',
			'created_at' => '2026-01-23 15:10',
		],
		[
			'employee' => 'Phạm C',
			'type' => 'Làm việc từ xa',
			'from' => '2026-01-24',
			'to' => '2026-01-24',
			'days' => 1,
			'status' => 'rejected',
			'reason' => 'Không đủ nhân sự onsite',
			'approver' => 'Quản lý dự án',
			'created_at' => '2026-01-22 11:05',
		],
	];

	$statusColors = [
		'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Đã duyệt', 'icon' => 'fa-circle-check'],
		'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Chờ duyệt', 'icon' => 'fa-clock'],
		'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Từ chối', 'icon' => 'fa-circle-xmark'],
	];
@endphp

@section('content')
<div class="space-y-6">
	<!-- Thống kê nhanh -->
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
		<div class="bg-white rounded-xl shadow-sm p-5 flex items-center justify-between">
			<div>
				<p class="text-sm text-gray-600">Đang nghỉ hôm nay</p>
				<div class="text-3xl font-bold text-gray-800">{{ $summary['active_today'] }}</div>
			</div>
			<div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
				<i class="fas fa-calendar-day text-xl"></i>
			</div>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5 flex items-center justify-between">
			<div>
				<p class="text-sm text-gray-600">Đã duyệt</p>
				<div class="text-3xl font-bold text-gray-800">{{ $summary['approved'] }}</div>
			</div>
			<div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
				<i class="fas fa-circle-check text-xl"></i>
			</div>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5 flex items-center justify-between">
			<div>
				<p class="text-sm text-gray-600">Chờ duyệt</p>
				<div class="text-3xl font-bold text-gray-800">{{ $summary['pending'] }}</div>
			</div>
			<div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
				<i class="fas fa-clock text-xl"></i>
			</div>
		</div>
		<div class="bg-white rounded-xl shadow-sm p-5 flex items-center justify-between">
			<div>
				<p class="text-sm text-gray-600">Từ chối</p>
				<div class="text-3xl font-bold text-gray-800">{{ $summary['rejected'] }}</div>
			</div>
			<div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
				<i class="fas fa-circle-xmark text-xl"></i>
			</div>
		</div>
	</div>

	<!-- Bộ lọc và hành động -->
	<div class="bg-white rounded-xl shadow-sm overflow-hidden">
		<div class="flex flex-wrap items-center justify-between gap-4 px-5 py-4 border-b border-gray-100">
			<div class="flex items-center gap-2 text-gray-700 font-semibold">
				<i class="fas fa-filter"></i>
				<span>Bộ lọc</span>
			</div>
			<div class="flex items-center gap-2">
				<button id="toggle-filters" type="button" class="p-2 rounded-full text-gray-600 hover:bg-gray-100" aria-label="Ẩn/hiện bộ lọc">
					<i class="fas fa-angle-down"></i>
				</button>
				<button id="open-leave-modal" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
					<i class="fas fa-plus mr-2"></i> Tạo đơn nghỉ
				</button>
			</div>
		</div>

		<div id="filters-content" class="px-5 py-4 space-y-4">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Loại nghỉ</label>
					<select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
						<option value="">Tất cả</option>
						@foreach($leaveTypes as $type)
							<option value="{{ $type }}" {{ ($filters['type'] ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
						@endforeach
					</select>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
					<select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
						<option value="">Tất cả</option>
						<option value="approved" {{ ($filters['status'] ?? '') === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
						<option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
						<option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
					</select>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
					<input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" value="{{ $filters['from'] ?? '' }}">
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
					<input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" value="{{ $filters['to'] ?? '' }}">
				</div>
			</div>
			<div class="flex items-center justify-between">
				<div class="flex gap-2">
					<button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Áp dụng</button>
					<button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">Xóa lọc</button>
				</div>
				<div class="flex gap-2 text-sm text-gray-500">
					<span class="inline-flex items-center gap-1"><i class="fas fa-circle text-green-500 text-xs"></i> Đã duyệt</span>
					<span class="inline-flex items-center gap-1"><i class="fas fa-circle text-yellow-500 text-xs"></i> Chờ duyệt</span>
					<span class="inline-flex items-center gap-1"><i class="fas fa-circle text-red-500 text-xs"></i> Từ chối</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Danh sách đơn nghỉ -->
	<div class="bg-white rounded-xl shadow-sm overflow-hidden">
		<div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
			<div class="font-semibold text-gray-800">Đơn nghỉ gần đây</div>
			<button class="text-sm text-blue-600 hover:text-blue-700">Xuất CSV</button>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nhân viên</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Từ</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đến</th>
						<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Số ngày</th>
						<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lý do</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người duyệt</th>
						<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
						<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@forelse($leaveRequests as $leave)
						@php
							$meta = $statusColors[$leave['status']] ?? $statusColors['pending'];
						@endphp
						<tr class="hover:bg-blue-50">
							<td class="px-4 py-4 text-sm text-gray-900">{{ $leave['employee'] }}</td>
							<td class="px-4 py-4 text-sm text-gray-700">{{ $leave['type'] }}</td>
							<td class="px-4 py-4 text-sm text-gray-700">{{ 
								\Carbon\Carbon::parse($leave['from'])->format('d/m/Y') }}</td>
							<td class="px-4 py-4 text-sm text-gray-700">{{ 
								\Carbon\Carbon::parse($leave['to'])->format('d/m/Y') }}</td>
							<td class="px-4 py-4 text-center text-sm font-semibold text-gray-800">{{ $leave['days'] }}</td>
							<td class="px-4 py-4 text-center">
								<span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
									<i class="fas {{ $meta['icon'] }}"></i>
									{{ $meta['label'] }}
								</span>
							</td>
							<td class="px-4 py-4 text-sm text-gray-700 max-w-xs">{{ $leave['reason'] }}</td>
							<td class="px-4 py-4 text-sm text-gray-700">{{ $leave['approver'] }}</td>
							<td class="px-4 py-4 text-sm text-gray-500">{{ $leave['created_at'] }}</td>
							<td class="px-4 py-4 text-center text-sm">
								<div class="flex items-center justify-center gap-3 text-gray-500">
									<button class="hover:text-blue-600" title="Chi tiết"><i class="fas fa-eye"></i></button>
									<button class="hover:text-green-600" title="Duyệt"><i class="fas fa-check"></i></button>
									<button class="hover:text-red-600" title="Từ chối"><i class="fas fa-xmark"></i></button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="10" class="px-4 py-10 text-center text-gray-500">
								<i class="fas fa-calendar-xmark text-3xl mb-3"></i>
								<p>Chưa có đơn nghỉ nào.</p>
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal tạo đơn nghỉ -->
<div id="leave-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
	<div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden">
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
			<div class="text-lg font-semibold text-gray-800">Tạo đơn nghỉ</div>
			<button id="close-leave-modal" class="text-gray-500 hover:text-gray-700">
				<i class="fas fa-times"></i>
			</button>
		</div>
		<div class="p-6 space-y-4">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Loại nghỉ</label>
					<select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
						@foreach($leaveTypes as $type)
							<option value="{{ $type }}">{{ $type }}</option>
						@endforeach
					</select>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Người duyệt</label>
					<input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Nhập email hoặc tên quản lý">
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
					<input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
					<input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
				</div>
			</div>
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">Lý do</label>
				<textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Mô tả ngắn gọn"></textarea>
			</div>
			<div class="flex items-center justify-end gap-3">
				<button type="button" id="cancel-leave-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">Hủy</button>
				<button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Gửi duyệt</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	document.addEventListener('DOMContentLoaded', () => {
		const filterContent = document.getElementById('filters-content');
		const filterToggle = document.getElementById('toggle-filters');
		const filterStorageKey = 'leaves_filters_collapsed';

		const modal = document.getElementById('leave-modal');
		const openModalBtn = document.getElementById('open-leave-modal');
		const closeModalBtn = document.getElementById('close-leave-modal');
		const cancelModalBtn = document.getElementById('cancel-leave-modal');

		const initCollapsed = localStorage.getItem(filterStorageKey);
		if (initCollapsed === 'collapsed') {
			filterContent?.classList.add('hidden');
		}

		filterToggle?.addEventListener('click', () => {
			filterContent?.classList.toggle('hidden');
			const collapsed = filterContent?.classList.contains('hidden');
			localStorage.setItem(filterStorageKey, collapsed ? 'collapsed' : 'expanded');
		});

		const openModal = () => modal?.classList.remove('hidden');
		const closeModal = () => modal?.classList.add('hidden');

		openModalBtn?.addEventListener('click', openModal);
		closeModalBtn?.addEventListener('click', closeModal);
		cancelModalBtn?.addEventListener('click', closeModal);
		modal?.addEventListener('click', (e) => {
			if (e.target === modal) closeModal();
		});
	});
</script>
@endsection
