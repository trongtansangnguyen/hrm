@extends('layouts.hrm')

@section('title', 'Quản lý phòng ban')

@section('page-title', 'Quản lý phòng ban')

@section('content')
<div class="space-y-6">
    <!-- Filters Section -->
    <div id="filters-section" class="sticky top-16 z-20 bg-white rounded-lg shadow">
        <div class="flex justify-end">
            <button id="toggle-filters" type="button" class="p-2 rounded-full text-gray-600 hover:bg-gray-100" aria-label="Toggle filters">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div id="filters-content" class="mt-2 p-6">
        <form method="GET" action="{{ route('management.departments.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Tên phòng ban..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
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
                        href="{{ route('management.departments.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                        Xóa lọc
                    </a>
                </div>
                <a
                    href="{{ route('management.departments.create') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                    Tạo mới
                </a>
            </div>
        </form>
        </div>
    </div>

    <!-- Departments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('management.departments.index', array_merge($filters, [
                                'sort_by' => 'name',
                                'sort_order' => ($filters['sort_by'] ?? 'created_at') === 'name' && ($filters['sort_order'] ?? 'desc') === 'desc' ? 'asc' : 'desc'
                            ])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                Tên phòng ban
                                @if(($filters['sort_by'] ?? 'created_at') === 'name')
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
                            Mô tả
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quản lý
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('management.departments.index', array_merge($filters, [
                                'sort_by' => 'created_at',
                                'sort_order' => ($filters['sort_by'] ?? 'created_at') === 'created_at' && ($filters['sort_order'] ?? 'desc') === 'desc' ? 'asc' : 'desc'
                            ])) }}" class="inline-flex items-center gap-1 hover:text-gray-700">
                                Ngày tạo
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
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($departments as $key => $department)
                        <tr class="hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $key+1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $department->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                {{ Str::limit($department->description, 50) ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $department->manager ? $department->manager->full_name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $department->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <a
                                        href="{{ route('management.departments.show', $department) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a
                                        href="{{ route('management.departments.edit', $department) }}"
                                        class="text-yellow-600 hover:text-yellow-900"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('management.departments.destroy', $department) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng ban này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-building text-4xl mb-4"></i>
                                <p>Không có phòng ban nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @include('layouts.pagination', [
        'paginator' => $departments,
        'route' => route('management.departments.index'),
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
        const storageKey = 'management_departments_filters_collapsed';

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
    });
</script>
@endsection
