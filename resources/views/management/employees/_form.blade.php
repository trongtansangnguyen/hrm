@php
    $employee = $employee ?? null;
    $statusOptions = [
        1 => 'Đang làm việc',
        2 => 'Đã nghỉ',
        3 => 'Tạm dừng',
    ];

    $genderOptions = [
        0 => 'Nam',
        1 => 'Nữ',
        2 => 'Khác',
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="employee_code" class="block text-sm font-medium text-gray-700 mb-2">
            Mã nhân viên <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="employee_code"
            id="employee_code"
            value="{{ old('employee_code', $employee?->employee_code) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('employee_code') border-red-500 @enderror"
            required
        >
        @error('employee_code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="identity_number" class="block text-sm font-medium text-gray-700 mb-2">
            CMND/CCCD <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="identity_number"
            id="identity_number"
            value="{{ old('identity_number', $employee?->identity_number) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('identity_number') border-red-500 @enderror"
            required
        >
        @error('identity_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
            Họ <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="first_name"
            id="first_name"
            value="{{ old('first_name', $employee?->first_name) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
            required
        >
        @error('first_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
            Tên <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="last_name"
            id="last_name"
            value="{{ old('last_name', $employee?->last_name) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
            required
        >
        @error('last_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email <span class="text-red-500">*</span>
        </label>
        <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', $employee?->email) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
            required
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
        <input
            type="text"
            name="phone"
            id="phone"
            value="{{ old('phone', $employee?->phone) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
        >
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
            Ngày sinh <span class="text-red-500">*</span>
        </label>
        <input
            type="date"
            name="date_of_birth"
            id="date_of_birth"
            value="{{ old('date_of_birth', $employee?->date_of_birth?->format('Y-m-d')) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror"
            required
        >
        @error('date_of_birth')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="join_date" class="block text-sm font-medium text-gray-700 mb-2">
            Ngày vào làm <span class="text-red-500">*</span>
        </label>
        <input
            type="date"
            name="join_date"
            id="join_date"
            value="{{ old('join_date', $employee?->join_date?->format('Y-m-d')) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('join_date') border-red-500 @enderror"
            required
        >
        @error('join_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
            Giới tính <span class="text-red-500">*</span>
        </label>
        <select
            name="gender"
            id="gender"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gender') border-red-500 @enderror"
            required
        >
            <option value="">-- Chọn giới tính --</option>
            @foreach($genderOptions as $value => $label)
                <option value="{{ $value }}" {{ (string) old('gender', $employee?->gender?->value) === (string) $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('gender')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
            Trạng thái <span class="text-red-500">*</span>
        </label>
        <select
            name="status"
            id="status"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
            required
        >
            <option value="">-- Chọn trạng thái --</option>
            @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ (string) old('status', $employee?->status?->value ?? 1) === (string) $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">Phòng ban</label>
        <select
            name="department_id"
            id="department_id"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('department_id') border-red-500 @enderror"
        >
            <option value="">-- Chọn phòng ban --</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ (string) old('department_id', $employee?->department_id) === (string) $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
        <textarea
            name="address"
            id="address"
            rows="4"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
        >{{ old('address', $employee?->address) }}</textarea>
        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>