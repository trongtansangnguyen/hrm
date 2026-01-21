@extends('layouts.auth')

@section('title', 'Đặt lại mật khẩu - HRM System')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Đặt lại mật khẩu</h2>
    <p class="text-gray-600 text-sm mt-1">Nhập mật khẩu mới của bạn</p>
</div>

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

<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    
    <input type="hidden" name="token" value="{{ $token }}">
    
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

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock text-gray-400"></i> Mật khẩu mới
        </label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
            placeholder="••••••••"
        >
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock text-gray-400"></i> Xác nhận mật khẩu mới
        </label>
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            placeholder="••••••••"
        >
    </div>

    <button 
        type="submit" 
        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-[1.02] transition-all shadow-lg"
    >
        <i class="fas fa-key"></i> Đặt lại mật khẩu
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