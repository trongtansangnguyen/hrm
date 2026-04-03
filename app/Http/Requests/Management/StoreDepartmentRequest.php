<?php

namespace App\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên phòng ban',
            'description' => 'mô tả',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên phòng ban là bắt buộc.',
            'name.unique' => 'Tên phòng ban này đã tồn tại.',
            'name.max' => 'Tên phòng ban không được vượt quá :max ký tự.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
        ];
    }
}
