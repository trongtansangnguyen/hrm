@if($paginator->hasPages() || $paginator->total() > 0)
    <div class="flex items-center justify-between bg-white px-6 py-3 rounded-lg shadow">
        <div class="text-sm text-gray-700">
            Hiển thị <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span> 
            đến <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span> 
            trong tổng số <span class="font-medium">{{ $paginator->total() }}</span> kết quả
        </div>
        <div class="flex items-center gap-4">
            <form method="GET" action="{{ $route }}" class="flex items-center gap-2">
                @foreach($filters as $key => $value)
                    @if($key !== 'per_page' && $value !== null && $value !== '')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <label for="per_page" class="text-sm text-gray-600">Hiển thị:</label>
                <select 
                    name="per_page" 
                    id="per_page"
                    onchange="this.form.submit()"
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="10" {{ ($filters['per_page'] ?? 20) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ ($filters['per_page'] ?? 20) == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ ($filters['per_page'] ?? 20) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ ($filters['per_page'] ?? 20) == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
            <div class="flex gap-2">
                @if(!$paginator->onFirstPage())
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Trước
                    </a>
                @endif

                @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Sau
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
