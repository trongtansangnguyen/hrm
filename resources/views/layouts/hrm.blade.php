<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRM System')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside 
        id="sidebar" 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 flex flex-col shadow-xl"
        >
            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto py-4 custom-scrollbar">
                <!-- Main Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Main
                    </div>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    @can('is-admin-or-manager')
                    <a href="{{ route('logs') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('logs') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-history w-5"></i>
                        <span class="ml-3">Hoạt động</span>
                    </a>
                    @endcan
                </div>

                @can('is-admin-or-manager')
                <!-- Quản lý Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Quản lý
                    </div>
                    <a href="{{ route('management.users.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.users.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Tài khoản</span>
                    </a>
                    <a href="{{ route('management.employees.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.employees.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Nhân viên</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-building w-5"></i>
                        <span class="ml-3">Phòng ban</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-briefcase w-5"></i>
                        <span class="ml-3">Vị trí</span>
                    </a>
                    <a href="{{ route('management.candidates.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.candidates.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-user-tie w-5"></i>
                        <span class="ml-3">Ứng viên</span>
                    </a>
                    <a href="{{ route('management.leaves.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.leaves.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-user-tie w-5"></i>
                        <span class="ml-3">Nghỉ phép</span>
                    </a>                                                                                                                        
                    <a href="{{ route('management.allowances.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.allowances.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-list-ul w-5"></i>
                        <span class="ml-3">Phụ cấp</span>
                    </a>
                </div>
                @endcan

                <!-- Chấm công Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Chấm công
                    </div>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-clock w-5"></i>
                        <span class="ml-3">Điểm danh</span>
                    </a>
                    <a href="{{ route('employee-leaves.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('employee-leaves.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-calendar-check w-5"></i>
                        <span class="ml-3">Nghỉ phép</span>
                    </a>
                </div>

                <!-- Lương thưởng Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Lương thưởng
                    </div>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span class="ml-3">Bảng lương</span>
                    </a>
                </div>

                <!-- Hệ thống Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Hệ thống
                    </div>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-user-shield w-5"></i>
                        <span class="ml-3">Người dùng</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-history w-5"></i>
                        <span class="ml-3">Nhật ký</span>
                    </a>
                    <a href="{{ route('password.change') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('password.change') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-key w-5"></i>
                        <span class="ml-3">Đổi mật khẩu</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 min-h-screen transition-all duration-300">
            <!-- Header -->
            <header class="sticky top-0 z-40 bg-white shadow-sm w-full">
                <div class="flex items-center justify-between px-4 md:px-6 py-4">
                    <!-- Mobile Menu Toggle -->
                    <button id="sidebar-toggle" class="md:hidden p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Page Title -->
                    <h2 class="text-lg md:text-2xl font-bold text-gray-800 truncate ml-2 md:ml-0">
                        @yield('page-title', 'Dashboard')
                    </h2>

                    <!-- User Info -->
                    <div class="flex items-center gap-4">
                        <!-- User Dropdown -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                            </div>
                            <div class="hidden md:block">
                                <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->email }}</div>
                                <div class="text-xs text-gray-500">
                                    @switch(Auth::user()->role)
                                        @case(\App\Enums\UserRole::ADMIN)
                                            Admin
                                            @break
                                        @case(\App\Enums\UserRole::MANAGER)
                                            Manager
                                            @break
                                        @case(\App\Enums\UserRole::EMPLOYEE)
                                            Employee
                                            @break
                                        @default
                                            User
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden md:inline ml-2">Đăng xuất</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
    </div>

    <!-- Global Toast Notifications -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2">
        @if(session('success'))
            <div class="toast flex items-start gap-3 bg-green-600 text-white shadow rounded-lg p-4" data-type="success">
                <i class="fas fa-check-circle text-xl"></i>
                <div class="flex-1 text-sm">{{ session('success') }}</div>
                <button class="ml-2 text-white/80 hover:text-white" aria-label="Close" data-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        @if(session('warning'))
            <div class="toast flex items-start gap-3 bg-yellow-500 text-white shadow rounded-lg p-4" data-type="warning">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div class="flex-1 text-sm">{{ session('warning') }}</div>
                <button class="ml-2 text-white/80 hover:text-white" aria-label="Close" data-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="toast flex items-start gap-3 bg-red-600 text-white shadow rounded-lg p-4" data-type="error">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <div class="flex-1 text-sm">{{ session('error') }}</div>
                <button class="ml-2 text-white/80 hover:text-white" aria-label="Close" data-close>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            };

            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);

            // Xử lý khi xoay màn hình hoặc resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    // Nếu đang ở màn hình nhỏ, đảm bảo menu đóng nếu overlay đang ẩn
                    if (sidebarOverlay.classList.contains('hidden')) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        });
        
        // Toasts: auto-dismiss success after 5s; error/warning require manual close
        const toastContainer = document.getElementById('toast-container');
        const toasts = toastContainer ? toastContainer.querySelectorAll('.toast') : [];
        toasts.forEach((toast) => {
            const type = toast.getAttribute('data-type');
            const closeBtn = toast.querySelector('[data-close]');
            closeBtn?.addEventListener('click', () => toast.remove());
            if (type === 'success' || type === 'info') {
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>