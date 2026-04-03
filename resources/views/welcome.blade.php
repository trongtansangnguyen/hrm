<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGU Tech Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script> 
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#f6f8fa] text-[#1f2328] font-sans min-h-screen">

    <header class="bg-[#24292f] py-3 shadow-sm relative z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4 text-white">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                        <i class="fas fa-building text-2xl"></i>
                        <span class="font-bold text-lg tracking-tight">SGU Tech Hub</span>
                    </a>
                    
                    <nav class="hidden md:flex gap-4 ml-6 text-sm font-medium text-gray-300">
                        <a href="#about" class="hover:text-white transition">Về chúng tôi</a>
                        <a href="{{ route('public.candidates.create') }}" class="hover:text-white transition">Tuyển dụng</a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-300 hover:text-white p-2 focus:outline-none"
                    >
                        <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <div 
            x-show="mobileMenuOpen" 
            @click.away="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="absolute left-0 right-0 top-full bg-[#24292f] border-t border-gray-700 shadow-2xl md:hidden z-50"
        >
            <nav class="flex flex-col px-4 py-4 text-sm font-medium text-gray-300">
                <a href="#about" @click="mobileMenuOpen = false" class="hover:text-white py-3 border-b border-gray-800 flex items-center justify-between">
                    Về chúng tôi <i class="fas fa-chevron-right text-xs opacity-50"></i>
                </a>
                <a href="{{ route('public.candidates.create') }}" @click="mobileMenuOpen = false" class="hover:text-white py-3 border-b border-gray-800 flex items-center justify-between">
                    Tuyển dụng <i class="fas fa-chevron-right text-xs opacity-50"></i>
                </a>
                <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="hover:text-white py-3 border-b border-gray-800 flex items-center justify-between">
                    Truy cập hệ thống <i class="fas fa-chevron-right text-xs opacity-50"></i>
                </a>
            </nav>
        </div>

        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
            style="top: 60px;" 
        ></div>
    </header>

    <section class="bg-[#24292f] text-white pt-20 pb-28 border-b border-gray-700">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <span class="text-blue-400 font-mono text-sm mb-4 block">Hệ thống quản trị nội bộ v1.0</span>
            <h1 class="text-4xl sm:text-6xl font-bold mb-6 tracking-tight">
                Xây dựng văn hóa doanh nghiệp số tại SGU Tech Hub
            </h1>
            <p class="text-xl text-gray-400 mb-10 max-w-3xl mx-auto leading-relaxed">
                Chúng tôi tối ưu hóa sức mạnh nhân sự thông qua nền tảng công nghệ tập trung. 
                Nơi mọi quy trình từ tuyển dụng đến phát triển nghề nghiệp được minh bạch hóa hoàn toàn.
            </p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('dashboard') }}" class="bg-[#2da44e] hover:bg-[#2c974b] px-8 py-3 rounded-md font-bold text-lg transition flex items-center gap-2">
                    <i class="fas fa-rocket"></i> Truy cập hệ thống ngay
                </a>
                <a href="#about" class="bg-transparent border border-gray-500 hover:border-white px-8 py-3 rounded-md font-bold text-lg transition">
                    Tìm hiểu về chúng tôi
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 px-4 -mt-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="bg-white border border-[#d0d7de] p-6 rounded-lg shadow-sm hover:border-blue-500 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-blue-50 rounded-md">
                            <i class="fas fa-fingerprint text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Minh bạch thông tin</h3>
                    </div>
                    <p class="text-[#656d76] text-sm leading-6">
                        Mọi nhân viên đều có quyền truy cập hồ sơ cá nhân, lộ trình thăng tiến và bảng lương công khai, đảm bảo tính công bằng tuyệt đối trong tổ chức.
                    </p>
                </div>

                <div class="bg-white border border-[#d0d7de] p-6 rounded-lg shadow-sm hover:border-blue-500 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-green-50 rounded-md">
                            <i class="fas fa-seedling text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Phát triển tài năng</h3>
                    </div>
                    <p class="text-[#656d76] text-sm leading-6">
                        Hệ thống tích hợp các khóa đào tạo nội bộ và theo dõi kỹ năng (Skills Map), giúp bạn định hướng phát triển sự nghiệp bền vững tại công ty.
                    </div>

                <div class="bg-white border border-[#d0d7de] p-6 rounded-lg shadow-sm hover:border-blue-500 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-purple-50 rounded-md">
                            <i class="fas fa-hand-holding-heart text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Chế độ phúc lợi</h3>
                    </div>
                    <p class="text-[#656d76] text-sm leading-6">
                        Đăng ký nghỉ phép, bảo hiểm và nhận thưởng năng suất chỉ trong vài giây. Chúng tôi ưu tiên trải nghiệm hạnh phúc của mỗi thành viên.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="border-t border-[#d0d7de] py-16 bg-[#f6f8fa]">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-center text-sm font-semibold text-[#656d76] uppercase tracking-[0.2em] mb-12">Chỉ số phát triển doanh nghiệp</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-extrabold text-[#1f2328]">500+</p>
                    <p class="text-[#656d76] text-xs font-bold mt-2">Nhân sự chính thức</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-[#1f2328]">12</p>
                    <p class="text-[#656d76] text-xs font-bold mt-2">Phòng ban chuyên môn</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-[#1f2328]">05</p>
                    <p class="text-[#656d76] text-xs font-bold mt-2">Văn phòng đại diện</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold text-[#1f2328]">Top 10</p>
                    <p class="text-[#656d76] text-xs font-bold mt-2">Môi trường làm việc</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 px-4 border-t border-[#d0d7de]">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4 text-[#656d76] text-xs">
                <i class="fas fa-building text-2xl"></i>
                <span>© 2026 SGU Tech Hub, Inc.</span>
                <a href="#" class="hover:text-blue-600">Terms</a>
                <a href="#" class="hover:text-blue-600">Privacy</a>
            </div>
            <div class="flex gap-6 text-[#656d76] text-sm">
                <a href="#" class="hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-blue-600"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>