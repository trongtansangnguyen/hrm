@extends('layouts.hrm')

@section('title', 'Nghỉ phép của tôi')
@section('page-title', 'Nghỉ phép của tôi')

@php
    $statusColors = [
        1 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Chờ duyệt', 'icon' => 'fa-clock'],
        2 => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Đã duyệt', 'icon' => 'fa-circle-check'],
        3 => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Từ chối', 'icon' => 'fa-circle-xmark'],
    ];
@endphp

@section('content')
<div class="space-y-6">
    @if ($message = Session::get('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600"></i>
            <div>
                <p class="text-green-800 font-medium">{{ $message }}</p>
            </div>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            <div>
                <p class="text-red-800 font-medium">{{ $message }}</p>
            </div>
        </div>
    @endif

   

    <!-- Nút tạo đơn -->
    @if($employee)
        <div class="flex justify-end">
            <button id="open-leave-modal" type="button" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i> Tạo đơn nghỉ mới
            </button>
        </div>
    @endif

    <!-- Danh sách đơn nghỉ -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span>Danh sách đơn nghỉ</span>
                <span class="ml-auto text-sm font-normal text-gray-600">Tổng: {{ $leaveRequests->count() }} đơn</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại nghỉ</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Từ ngày</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đến ngày</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lý do</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leaveRequests as $leave)
                        @php
                            $meta = $statusColors[$leave->status->value] ?? $statusColors[1];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">Nghỉ phép năm</td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($leave->from_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($leave->to_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $meta['bg'] }} {{ $meta['text'] }}">
                                    <i class="fas {{ $meta['icon'] }}"></i>
                                    {{ $meta['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $leave->reason ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($leave->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm">
                                <button class="text-blue-600 hover:text-blue-800 transition-colors" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-3 text-gray-300"></i>
                                <p class="text-base">Bạn chưa tạo đơn nghỉ nào</p>
                                <p class="text-sm mt-1">Nhấn nút "Tạo đơn nghỉ mới" để bắt đầu</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal tạo đơn nghỉ -->
<div id="leave-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="text-lg font-semibold text-gray-800">Tạo đơn nghỉ mới</div>
            <button id="close-leave-modal" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('employee-leaves.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loại nghỉ <span class="text-red-500">*</span></label>
                    <select name="leave_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                        <option value="">-- Chọn loại nghỉ --</option>
                    </select>
                    @error('leave_type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số ngày <span class="text-red-500">*</span></label>
                    <input type="number" id="leave-days" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-gray-100" disabled>
                    <p class="text-xs text-gray-500 mt-1">Tự động tính từ ngày từ - đến</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày <span class="text-red-500">*</span></label>
                    <input type="date" name="from_date" id="from-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    @error('from_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày <span class="text-red-500">*</span></label>
                    <input type="date" name="to_date" id="to-date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    @error('to_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lý do <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Mô tả lý do xin nghỉ..." required></textarea>
                @error('reason')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-800 flex gap-2">
                <i class="fas fa-info-circle flex-shrink-0 mt-0.5"></i>
                <p>Đơn nghỉ của bạn sẽ được gửi tới trưởng phòng để duyệt. Vui lòng điền đầy đủ thông tin.</p>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" id="cancel-leave-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">Hủy</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Gửi đơn</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('leave-modal');
        const openModalBtn = document.getElementById('open-leave-modal');
        const closeModalBtn = document.getElementById('close-leave-modal');
        const cancelModalBtn = document.getElementById('cancel-leave-modal');
        const fromDate = document.getElementById('from-date');
        const toDate = document.getElementById('to-date');
        const leaveDays = document.getElementById('leave-days');

        const openModal = () => modal?.classList.remove('hidden');
        const closeModal = () => modal?.classList.add('hidden');

        openModalBtn?.addEventListener('click', openModal);
        closeModalBtn?.addEventListener('click', closeModal);
        cancelModalBtn?.addEventListener('click', closeModal);
        modal?.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Tính số ngày nghỉ
        const calculateDays = () => {
            if (fromDate.value && toDate.value) {
                const from = new Date(fromDate.value);
                const to = new Date(toDate.value);
                const days = Math.floor((to - from) / (1000 * 60 * 60 * 24)) + 1;
                leaveDays.value = Math.max(1, days);
            }
        };

        fromDate?.addEventListener('change', calculateDays);
        toDate?.addEventListener('change', calculateDays);
    });
</script>
@endsection
