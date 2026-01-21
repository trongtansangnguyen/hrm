@extends('layouts.auth')

@section('title', 'Quên mật khẩu - HRM System')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Quên mật khẩu</h2>
    <p class="text-gray-600 text-sm mt-1">Nhập email để nhận link đặt lại mật khẩu</p>
</div>

@if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
        <i class="fas fa-check-circle"></i>
        <span class="text-sm">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
        @foreach($errors->all() as $error)
            <div class="flex items-center gap-2 text-sm">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf
    
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-envelope text-gray-400"></i> Email
        </label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            required 
            autofocus
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
            placeholder="email@example.com"
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button 
        type="submit" 
        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-[1.02] transition-all shadow-lg"
    >
        <i class="fas fa-paper-plane"></i> Gửi link đặt lại mật khẩu
    </button>
</form>

<div class="mt-6 text-center">
    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800 font-medium">
        <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
    </a>
</div>
@endsection

@section('footer-links')
    <p class="text-white text-sm">
        © 2026 HRM System. All rights reserved.
    </p>
@endsection