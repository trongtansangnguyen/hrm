<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRM System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <i class="fas fa-building text-3xl text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">HRM System</h1>
            <p class="text-blue-100 mt-2">Human Resource Management</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @yield('content')
        </div>

        <!-- Footer Links -->
        <div class="text-center mt-6">
            @yield('footer-links')
        </div>
    </div>
</body>
</html>