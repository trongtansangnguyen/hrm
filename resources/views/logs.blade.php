@extends('layouts.hrm')

@section('title', 'Hoạt động - HRM System')
@section('page-title', 'Hoạt động')

@section('content')
<div class="space-y-6">
    <!-- Filters Section -->
    <div id="filters-section" class="sticky top-16 z-10 bg-white rounded-lg shadow">
        <div class="flex justify-end">
            <button id="toggle-filters" type="button" class="p-2 rounded-full text-gray-600 hover:bg-gray-100" aria-label="Toggle filters">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div id="filters-content" class="mt-2 p-6">
        <form method="GET" action="{{ route('logs') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input
                        type="text" 
                        name="search" 
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Action, IP, Email..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                </div>

                <!-- Action Filter -->
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Hành động</label>
                    <select 
                        name="action"
                        id="action"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ ($filters['action'] ?? '') === $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Table Name Filter -->
                <div>
                    <label for="table_name" class="block text-sm font-medium text-gray-700 mb-1">Đối tượng</label>
                    <select 
                        name="table_name" 
                        id="table_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($tableNames as $tableName)
                            <option value="{{ $tableName }}" {{ ($filters['table_name'] ?? '') === $tableName ? 'selected' : '' }}>
                                {{ $tableName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input 
                        type="date" 
                        name="date_from" 
                        id="date_from"
                        value="{{ $filters['date_from'] ?? '' }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input 
                        type="date" 
                        name="date_to" 
                        id="date_to"
                        value="{{ $filters['date_to'] ?? '' }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                </div>
            </div>

            <!-- Hidden Sort Fields -->
            <input type="hidden" name="sort_by" value="{{ $filters['sort_by'] ?? 'created_at' }}">
            <input type="hidden" name="sort_order" value="{{ $filters['sort_order'] ?? 'desc' }}">

            <!-- Action Buttons -->
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        Áp dụng
                    </button>
                    <a 
                        href="{{ route('logs') }}" 
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                        Xóa lọc
                    </a>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow relative z-20 overflow-visible">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Người thực hiện
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hành động
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bảng
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Record ID
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            IP Address
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('logs', array_merge($filters, [
                                'sort_by' => 'created_at',
                                'sort_order' => ($filters['sort_by'] ?? 'created_at') === 'created_at' && ($filters['sort_order'] ?? 'desc') === 'desc' ? 'asc' : 'desc'
                            ])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                Thời gian
                                @if(($filters['sort_by'] ?? 'created_at') === 'created_at')
                                    @if(($filters['sort_order'] ?? 'desc') === 'desc')
                                        <i class="fas fa-sort-down"></i>
                                    @else
                                        <i class="fas fa-sort-up"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Chi tiết
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $key => $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $key+1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ $log->user ? $log->user->email : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if(str_contains(strtolower($log->action), 'create')) bg-green-100 text-green-800
                                    @elseif(str_contains(strtolower($log->action), 'update')) bg-blue-100 text-blue-800
                                    @elseif(str_contains(strtolower($log->action), 'delete')) bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $log->table_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $log->record_id ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium relative group">
                                <button 
                                    type="button"
                                    class="text-blue-600 hover:text-blue-900 log-detail-btn" 
                                    title="Xem chi tiết" data-log-id="{{ $log->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-history text-4xl mb-4"></i>
                                <p>Không có hoạt động nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @include('layouts.pagination', [
        'paginator' => $logs,
        'route' => route('logs'),
        'filters' => $filters
    ])
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const panel = document.getElementById('filters-section');
        const content = document.getElementById('filters-content');
        const btn = document.getElementById('toggle-filters');
        const storageKey = 'logs_filters_collapsed';

        // Initialize from localStorage (collapsed = only icon bar visible)
        const initial = localStorage.getItem(storageKey);
        if (initial === 'collapsed') {
            content?.classList.add('hidden');
        }

        btn?.addEventListener('click', () => {
            content?.classList.toggle('hidden');
            const isCollapsed = content?.classList.contains('hidden');
            localStorage.setItem(storageKey, isCollapsed ? 'collapsed' : 'expanded');
        });

        // Tooltip overlay for log detail
        document.querySelectorAll('.log-detail-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const logId = this.getAttribute('data-log-id');
                const logDetail = document.getElementById('log-detail-data-' + logId);
                if (!logDetail) return;
                document.getElementById('logDetailContent').innerHTML = logDetail.innerHTML;
                document.getElementById('logDetailModal').classList.remove('hidden');
            });
        });
    });
    function closeLogDetail() {
        document.getElementById('logDetailModal').classList.add('hidden');
    }
</script>
@endsection

@foreach($logs as $log)
    <div id="log-detail-data-{{ $log->id }}" class="hidden">
        @if($log->old_values || $log->new_values)
            @if($log->old_values)
                <div class="mb-2">
                    <p class="font-semibold text-yellow-300 mb-1">Giá trị cũ:</p>
                    <pre class="text-gray-300 text-xs bg-gray-800 p-2 rounded overflow-auto max-h-48">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif
            @if($log->new_values)
                <div>
                    <p class="font-semibold text-green-300 mb-1">Giá trị mới:</p>
                    <pre class="text-gray-300 text-xs bg-gray-800 p-2 rounded overflow-auto max-h-48">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif
        @else
            <p class="text-gray-400">Không có dữ liệu thay đổi</p>
        @endif
    </div>
@endforeach

<!-- Log Detail Modal -->
<div id="logDetailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
    <div class="relative mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Chi tiết Log</h3>
            <button onclick="closeLogDetail()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="logDetailContent" class="mt-4">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>