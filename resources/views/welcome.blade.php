<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản lý Nhân Sự</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-500 via-purple-500 to-purple-700 min-h-screen">
    <!-- Header -->
    <header class="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex flex-col sm:flex-row justify-between items-center py-5 gap-4">
                <div class="flex items-center gap-3 text-white text-2xl font-bold">
                    <i class="fas fa-building text-3xl"></i>
                    <span>HRM System</span>
                </div>
                <div class="flex gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-20 px-4 text-white">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                HRM System
            </h1>
            <p class="text-lg sm:text-xl mb-10 opacity-90 max-w-2xl mx-auto">
                Hệ thống quản lý nhân sự hiện đại, giúp bạn dễ dàng tra cứu thông tin, chấm công, quản lý nghỉ phép và nhiều hơn nữa
            </p>
            <div class="flex flex-wrap gap-5 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-tachometer-alt"></i> Vào Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-white text-blue-600 rounded-lg text-lg font-semibold hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập hệ thống
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl sm:text-5xl font-bold text-center mb-16 text-gray-800">
                Các chức năng hỗ trợ
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Thông tin nhân viên</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tra cứu thông tin cá nhân, thông tin đồng nghiệp, phòng ban và chức vụ dễ dàng
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Chấm công thông minh</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Hệ thống chấm công tự động, theo dõi giờ làm việc chính xác và tiện lợi
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-money-bill-wave text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Tính lương tự động</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tự động tính lương, phụ cấp, thưởng dựa trên chấm công và các quy định
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-check text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Quản lý nghỉ phép</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Xử lý đơn nghỉ phép nhanh chóng, minh bạch và dễ dàng theo dõi
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Báo cáo chi tiết</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Thống kê, báo cáo đa dạng giúp đưa ra quyết định chính xác
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-tie text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Hồ sơ cá nhân</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Quản lý và cập nhật thông tin cá nhân, hồ sơ nghề nghiệp của bạn một cách tiện lợi
                    </p>
                </div>

                <!-- Feature 7 -->
                <a href="{{ route('public.candidates.create') }}" class="block group cursor-pointer">
            <div class="text-center p-8 bg-gray-50 rounded-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-tie text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Tuyển Dụng Nhân Sự</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tuyển dụng nhân sự dễ dàng, quản lý hồ sơ ứng viên và theo dõi tiến trình tuyển dụng hiệu quả.
                </p>
            </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-br from-blue-500 via-purple-500 to-purple-700 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 text-center text-white">
                <div>
                    <h3 class="text-5xl font-bold mb-3"><i class="fas fa-shield-alt"></i></h3>
                    <p class="text-lg opacity-90">Bảo mật cao</p>
                </div>
                <div>
                    <h3 class="text-5xl font-bold mb-3"><i class="fas fa-bolt"></i></h3>
                    <p class="text-lg opacity-90">Xử lý nhanh chóng</p>
                </div>
                <div>
                    <h3 class="text-5xl font-bold mb-3"><i class="fas fa-mobile-alt"></i></h3>
                    <p class="text-lg opacity-90">Truy cập mọi lúc</p>
                </div>
                <div>
                    <h3 class="text-5xl font-bold mb-3"><i class="fas fa-headset"></i></h3>
                    <p class="text-lg opacity-90">Hỗ trợ IT nội bộ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/20 backdrop-blur-md py-10 px-4 text-center text-white">
        <div class="max-w-7xl mx-auto">
            <p class="mb-4 opacity-80">&copy; 2026 Hệ thống Quản lý Nhân sự. Bản quyền thuộc về Công ty.</p>
            <div class="flex flex-wrap gap-8 justify-center">
                <a href="#" class="opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-book"></i> Hướng dẫn sử dụng
                </a>
                <a href="#" class="opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-question-circle"></i> Hỗ trợ
                </a>
                <a href="#" class="opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-envelope"></i> Liên hệ IT
                </a>
            </div>
        </div>
    </footer>
</body>
</html>