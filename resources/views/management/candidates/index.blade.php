@extends('layouts.hrm')

@section('title', 'Quản lý Ứng viên')
@section('page-title', 'Danh sách Ứng viên')

@section('content')
<div class="space-y-6">
    <div id="candidate-filters-section" class="sticky top-16 z-20 bg-white rounded-lg shadow">
        <div class="flex justify-end">
            <button id="toggle-candidate-filters" type="button" class="p-2 rounded-full text-gray-600 hover:bg-gray-100" aria-label="Toggle filters">
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div id="candidate-filters-content" class="mt-2 p-6">
            <form method="GET" action="{{ route('management.candidates.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Tìm tên, email, SĐT, vị trí..."
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
                            <option value="applied" {{ ($filters['status'] ?? '') === 'applied' ? 'selected' : '' }}>Mới nhận</option>
                            <option value="interview" {{ ($filters['status'] ?? '') === 'interview' ? 'selected' : '' }}>Phỏng vấn</option>
                            <option value="hired" {{ ($filters['status'] ?? '') === 'hired' ? 'selected' : '' }}>Tuyển dụng</option>
                            <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Loại</option>
                        </select>
                    </div>

                    <div>
                        <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Hiển thị</label>
                        <select name="per_page" id="per_page" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="10" {{ ($filters['per_page'] ?? 10) == 10 ? 'selected' : '' }}>10/trang</option>
                            <option value="20" {{ ($filters['per_page'] ?? 10) == 20 ? 'selected' : '' }}>20/trang</option>
                            <option value="50" {{ ($filters['per_page'] ?? 10) == 50 ? 'selected' : '' }}>50/trang</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Áp dụng
                        </button>
                        <a href="{{ route('management.candidates.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors text-sm font-medium">
                            Xóa lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tên ứng viên</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Phòng ban</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Vị trí</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($candidates as $candidate)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-medium text-gray-900">{{ $candidate->last_name }} {{ $candidate->first_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $candidate->jobPosition->department->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $candidate->jobPosition->title ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $candidate->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                @if($candidate->cv_path)
                                    <a href="{{ asset('storage/' . $candidate->cv_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-file-pdf"></i> Xem CV
                                    </a>
                                @else
                                    <span class="text-gray-400">Không có</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusValue = $candidate->status?->value;
                                    $class = '';
                                    $text = '';

                                    switch($statusValue) {
                                        case 3:
                                            $class = 'bg-green-100 text-green-800 border-green-200';
                                            $text = 'Tuyển dụng';
                                            break;
                                        case 2:
                                            $class = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                                            $text = 'Phỏng vấn';
                                            break;
                                        case 4:
                                            $class = 'bg-red-100 text-red-800 border-red-200';
                                            $text = 'Loại';
                                            break;
                                        default:
                                            $class = 'bg-blue-100 text-blue-800 border-blue-200';
                                            $text = 'Mới nhận';
                                    }
                                @endphp

                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $class }}">
                                    {{ $text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-3">
                                    <form action="{{ route('management.candidates.updateStatus', $candidate->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-md focus:ring-blue-500 py-1">
                                            <option value="applied" {{ $candidate->status?->value === 1 ? 'selected' : '' }}>Mới nhận</option>
                                            <option value="interview" {{ $candidate->status?->value === 2 ? 'selected' : '' }}>Phỏng vấn</option>
                                            <option value="hired" {{ $candidate->status?->value === 3 ? 'selected' : '' }}>Tuyển dụng</option>
                                            <option value="rejected" {{ $candidate->status?->value === 4 ? 'selected' : '' }}>Loại</option>
                                        </select>
                                    </form>
                                    <a href="{{ route('management.candidates.show', $candidate->id) }}" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-user-tie text-4xl mb-4"></i>
                                <p>Chưa có hồ sơ ứng viên nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.pagination', [
        'paginator' => $candidates,
        'route' => route('management.candidates.index'),
        'filters' => $filters ?? []
    ])
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const content = document.getElementById('candidate-filters-content');
        const btn = document.getElementById('toggle-candidate-filters');
        const storageKey = 'management_candidates_filters_collapsed';

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