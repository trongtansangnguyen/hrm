@extends('layouts.hrm')

@section('title', 'Đổi mật khẩu - HRM System')
@section('page-title', 'Đổi mật khẩu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800">Thay đổi mật khẩu</h3>
            <p class="text-gray-600 text-sm mt-1">Cập nhật mật khẩu của bạn để bảo mật tài khoản</p>
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
                    <div class="flex items-center gap-2 text-sm mb-1 last:mb-0">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update.change') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-gray-400"></i> Mật khẩu hiện tại
                </label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    required 
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('current_password') border-red-500 @enderror"
                    placeholder="Nhập mật khẩu hiện tại"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t pt-6">
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-key text-gray-400"></i> Mật khẩu mới
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                        placeholder="Nhập mật khẩu mới"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle"></i> Mật khẩu tối thiểu 8 ký tự
                    </p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-check-double text-gray-400"></i> Xác nhận mật khẩu mới
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Nhập lại mật khẩu mới"
                    >
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-[1.02] transition-all shadow-lg"
                >
                    <i class="fas fa-save"></i> Thay đổi mật khẩu
                </button>
                <a 
                    href="{{ route('dashboard') }}" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors"
                >
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
    </div>

    <!-- Security Tips -->
    <div class="mt-6 bg-blue-50 rounded-xl p-6 border border-blue-100">
        <h4 class="font-semibold text-blue-900 mb-3">
            <i class="fas fa-shield-alt"></i> Mẹo bảo mật
        </h4>
        <ul class="space-y-2 text-sm text-blue-800">
            <li><i class="fas fa-check text-blue-600"></i> Sử dụng mật khẩu mạnh với chữ hoa, chữ thường, số và ký tự đặc biệt</li>
            <li><i class="fas fa-check text-blue-600"></i> Không sử dụng cùng mật khẩu cho nhiều tài khoản</li>
            <li><i class="fas fa-check text-blue-600"></i> Thay đổi mật khẩu định kỳ để bảo mật tài khoản</li>
            <li><i class="fas fa-check text-blue-600"></i> Không chia sẻ mật khẩu với bất kỳ ai</li>
        </ul>
    </div>
</div>
@endsection