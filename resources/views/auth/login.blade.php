@extends('layouts.auth')

@section('title', 'Đăng nhập vào SGU Tech Hub')

@section('content')
{{-- Thông báo thành công --}}
@if(session('success'))
    <div class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 px-3 py-2 rounded-md text-sm">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-md">
        @foreach($errors->all() as $error)
            <div class="flex items-center gap-2 text-xs">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    
    <div>
        <label for="email" class="block text-sm font-normal text-[#1f2328] mb-2">
            Email
        </label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            required 
            autofocus
            class="w-full px-3 py-1.5 bg-[#f6f8fa] border border-[#d0d7de] rounded-md focus:border-[#0969da] focus:ring-2 focus:ring-[#0969da]/20 outline-none transition-all text-sm @error('email') border-red-500 @enderror"
        >
    </div>

    <div>
        <div class="flex justify-between items-center mb-2">
            <label for="password" class="text-sm font-normal text-[#1f2328]">
                Mật khẩu
            </label>
            <a href="{{ route('password.request') }}" class="text-xs text-[#0969da] hover:underline">
                Quên mật khẩu?
            </a>
        </div>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
            class="w-full px-3 py-1.5 bg-[#f6f8fa] border border-[#d0d7de] rounded-md focus:border-[#0969da] focus:ring-2 focus:ring-[#0969da]/20 outline-none transition-all text-sm @error('password') border-red-500 @enderror"
        >
    </div>

    <div class="flex items-center">
        <input 
            type="checkbox" 
            id="remember"
            name="remember" 
            class="w-3.5 h-3.5 text-[#0969da] border-[#d0d7de] rounded focus:ring-[#0969da]"
        >
        <label for="remember" class="ml-2 text-sm text-[#1f2328]">Ghi nhớ đăng nhập</label>
    </div>

    <button 
        type="submit" 
        class="w-full bg-[#29A5FF] hover:bg-[#135586] text-white font-semibold py-1.5 rounded-md shadow-sm transition-colors text-sm"
    >
        Đăng nhập
    </button>
</form>
@endsection