@extends('layouts.public')

@section('content')
<div class="min-h-screen w-full bg-slate-50 flex flex-col items-center py-12 px-4">
    
    <div class="w-full max-w-2xl mb-8 flex justify-between items-center">
        <a href="/" class="flex items-center text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Quay lại trang chủ</span>
        </a>
        <div class="text-right">
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Cơ hội nghề nghiệp</h2>
            <p class="text-slate-500 text-sm">Gia nhập đội ngũ cùng chúng tôi</p>
        </div>
    </div>

    <div class="w-full max-w-2xl bg-white p-10 rounded-2xl shadow-sm border border-slate-100">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('public.candidates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Họ và tên <span class="text-rose-500">*</span></label>
                    <input type="text" name="full_name" required
                        placeholder="Nguyễn Văn A"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email cá nhân <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required
                            placeholder="example@gmail.com"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Số điện thoại <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" required
                            placeholder="09xx xxx xxx"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Vị trí bạn quan tâm <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="job_position_id" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl appearance-none focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->title }} - {{ $position->department->description }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Đính kèm Hồ sơ (CV) <span class="text-rose-500">*</span></label>
                    <div id="cv-dropzone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600">
                                <span class="relative cursor-pointer font-semibold text-indigo-600 hover:text-indigo-500">Tải tệp lên</span>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p id="cv-help-text" class="text-xs text-slate-500 italic">PDF, DOC, DOCX tối đa 5MB</p>
                        </div>
                        <input id="cv-input" name="cv" type="file" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                    </div>
                    <p id="cv-file-name" class="mt-2 text-sm text-emerald-600 font-medium hidden"></p>
                    <div id="cv-actions" class="mt-3 hidden items-center gap-2">
                        <button
                            id="cv-change-btn"
                            type="button"
                            class="px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors"
                        >
                            Đổi file
                        </button>
                        <button
                            id="cv-remove-btn"
                            type="button"
                            class="px-3 py-1.5 text-sm font-medium text-rose-700 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100 transition-colors"
                        >
                            Xóa file
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 active:scale-[0.98]">
                    Nộp hồ sơ ngay
                </button>
            </div>
        </form>
    </div>

    <p class="mt-8 text-slate-400 text-sm text-center">
        Bằng cách nhấn nộp hồ sơ, bạn đồng ý với các điều khoản bảo mật của hệ thống HRM.
    </p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cvInput = document.getElementById('cv-input');
        const cvFileName = document.getElementById('cv-file-name');
        const cvHelpText = document.getElementById('cv-help-text');
        const cvDropzone = document.getElementById('cv-dropzone');
        const cvActions = document.getElementById('cv-actions');
        const cvChangeButton = document.getElementById('cv-change-btn');
        const cvRemoveButton = document.getElementById('cv-remove-btn');

        if (!cvInput || !cvFileName || !cvHelpText || !cvDropzone || !cvActions || !cvChangeButton || !cvRemoveButton) {
            return;
        }

        const resetCvState = function () {
            cvInput.value = '';
            cvFileName.textContent = '';
            cvFileName.classList.add('hidden');
            cvHelpText.textContent = 'PDF, DOC, DOCX tối đa 5MB';
            cvDropzone.classList.remove('border-emerald-400', 'bg-emerald-50/40');
            cvActions.classList.add('hidden');
            cvActions.classList.remove('flex');
        };

        const setSelectedFile = function (file) {
            cvFileName.textContent = `Đã chọn: ${file.name}`;
            cvFileName.classList.remove('hidden');
            cvHelpText.textContent = 'Tệp đã sẵn sàng để gửi.';
            cvDropzone.classList.add('border-emerald-400', 'bg-emerald-50/40');
            cvActions.classList.remove('hidden');
            cvActions.classList.add('flex');
        };

        cvInput.addEventListener('change', function (event) {
            const files = event.target.files;

            if (!files || files.length === 0) {
                resetCvState();
                return;
            }

            const file = files[0];

            if (files.length > 1) {
                const fileList = new DataTransfer();
                fileList.items.add(file);
                cvInput.files = fileList.files;
            }

            setSelectedFile(file);
        });

        cvChangeButton.addEventListener('click', function () {
            cvInput.click();
        });

        cvRemoveButton.addEventListener('click', function () {
            resetCvState();
        });
    });
</script>
@endsection