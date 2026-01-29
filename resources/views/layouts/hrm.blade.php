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
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-800 border-b border-gray-700">
                <h1 class="text-xl font-bold text-blue-400">
                    <i class="fas fa-building"></i> HRM System
                </h1>
            </div>

            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                <!-- Main Section -->
                <div class="mb-6">
                    <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Main
                    </div>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('logs') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('logs') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-history w-5"></i>
                        <span class="ml-3">Hoạt động</span>
                    </a>
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
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
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
                    <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-user-tie w-5"></i>
                        <span class="ml-3">Ứng viên</span>
                    </a>
                    <a href="{{ route('leaves') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
                        <i class="fas fa-user-tie w-5"></i>
                        <span class="ml-3">Nghỉ phép</span>
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
                    <a href="{{ route('employee-leaves.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 border-transparent">
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
                    <a href="{{ route('management.allowances.index') }}" 
                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors border-l-4 {{ request()->routeIs('management.allowances.*') ? 'border-blue-500 bg-gray-800 text-white' : 'border-transparent' }}">
                        <i class="fas fa-gift w-5"></i>
                        <span class="ml-3">Phụ cấp</span>
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
        <main class="flex-1 lg:ml-64">
            <!-- Header -->
            <header class="sticky top-0 z-40 bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile Menu Toggle -->
                    <button id="sidebar-toggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Page Title -->
                    <h2 class="text-2xl font-bold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h2>

                    <!-- User Info -->
                    <div class="flex items-center gap-4">
                        <!-- Notification -->
                        <button class="relative text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>

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
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

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
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
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