@extends('layouts.hrm')

@section('title', 'Quản lý tài khoản')

@section('page-title', 'Quản lý tài khoản')

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
        <form method="GET" action="{{ route('management.users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input 
                        type="text" 
                        name="search" 
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Email, tên..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                </div>

                <!-- Role Filter -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                    <select 
                        name="role" 
                        id="role"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->value }}" {{ ($filters['role'] ?? '') == $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    >
                        <option value="">Tất cả</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ ($filters['status'] ?? '') === (string)$status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
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
                        href="{{ route('management.users.index') }}" 
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                        Xóa lọc
                    </a>
                </div>
                <a
                    href="{{ route('management.users.create') }}" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                    Tạo mới
                </a>
            </div>
        </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vai trò
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('management.users.index', array_merge($filters, [
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
                    @forelse($users as $key => $user)
                        <tr class="hover:bg-blue-50 {{ auth()->id() === $user->id ? 'bg-blue-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $key+1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $user->role->badgeColor() }}-100 text-{{ $user->role->badgeColor() }}-800">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $user->status->badgeColor() }}-100 text-{{ $user->status->badgeColor() }}-800">
                                    {{ $user->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <a 
                                        href="{{ route('management.users.show', $user) }}" 
                                        class="text-blue-600 hover:text-blue-900" 
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a 
                                        href="{{ route('management.users.edit', $user) }}" 
                                        class="text-yellow-600 hover:text-yellow-900" 
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form 
                                            action="{{ route('management.users.destroy', $user) }}" 
                                            method="POST" 
                                            class="inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="text-red-600 hover:text-red-900" 
                                                title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p>Không có người dùng nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @include('layouts.pagination', [
        'paginator' => $users,
        'route' => route('management.users.index'),
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
        const storageKey = 'management_users_filters_collapsed';

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
