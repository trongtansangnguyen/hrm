<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGU Tech Hub')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f8fa] min-h-screen flex flex-col items-center pt-12 p-4 font-sans text-[#1f2328]">
    
    <div class="w-full max-w-[340px] text-center mb-6">
        <a href="/" class="inline-block hover:opacity-80 transition">
            <i class="fas fa-building text-5xl text-[#24292f]"></i>
        </a>
        <h1 class="text-2xl font-light mt-6 tracking-tight">SGU Tech Hub</h1>
    </div>

    <div class="w-full max-w-[340px]">
        <div class="bg-white border border-[#d0d7de] rounded-md p-5 shadow-sm">
            @yield('content')
        </div>
    </div>

    <footer class="mt-auto py-10 text-xs text-[#656d76] flex gap-4">
        <a href="#" class="hover:text-blue-600">Terms</a>
        <a href="#" class="hover:text-blue-600">Privacy</a>
        <a href="#" class="hover:text-blue-600">Docs</a>
        <span class="text-gray-300">Contact SGU Support</span>
    </footer>
</body>
</html>