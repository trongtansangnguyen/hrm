@extends('layouts.hrm')

@section('title', 'Quản lý tuyển dụng')
@section('page-title', 'Quản lý vị trí tuyển dụng')

@section('content')
<div class="space-y-6">
    <div id="job-filters-section" class="sticky top-16 z-20 bg-white rounded-lg shadow">
        <div class="flex justify-end">
            <button id="toggle-job-filters" type="button" class="p-2 rounded-full text-gray-600 hover:bg-gray-100" aria-label="Toggle filters">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div id="job-filters-content" class="mt-2 p-6">
            <form method="GET" action="{{ route('management.jobbatch.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Tìm vị trí, mô tả..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        >
                    </div>

                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Phòng ban</label>
                        <select name="department_id" id="department_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="">Tất cả</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ (string) ($filters['department_id'] ?? '') === (string) $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="">Tất cả</option>
                            <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Đang tuyển</option>
                            <option value="2" {{ ($filters['status'] ?? '') === '2' ? 'selected' : '' }}>Đóng</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Áp dụng
                        </button>
                        <a href="{{ route('management.jobbatch.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                            Xóa lọc
                        </a>
                    </div>
                    <a href="{{ route('management.jobbatch.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        Tạo mới
                    </a>
                </div>
            </form>
        </div>

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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tên vị trí</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Phòng ban</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ứng viên</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">{{ $job->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $job->department->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $job->candidates->count() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $job->status == 1 ? 'Đang tuyển' : 'Đóng' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('management.jobbatch.show', $job->id) }}" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('management.jobbatch.edit', $job->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('management.jobbatch.destroy', $job->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-briefcase text-4xl mb-4"></i>
                                <p>Chưa có vị trí tuyển dụng nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.pagination', [
        'paginator' => $jobs,
        'route' => route('management.jobbatch.index'),
        'filters' => $filters ?? []
    ])
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const content = document.getElementById('job-filters-content');
        const btn = document.getElementById('toggle-job-filters');
        const storageKey = 'management_jobbatch_filters_collapsed';

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