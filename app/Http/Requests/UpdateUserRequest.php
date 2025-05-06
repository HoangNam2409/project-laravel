<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email, ' . $this->id . ',id',
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
        ];
    }

    public function messages(): array
    {
        return  [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Bạn chưa nhập đúng định dạng email.',
            'email.unique' => 'Email của bạn đã tồn tại.',
            'name.required' => 'Bạn chưa nhập vào họ tên.',
            'user_catalogue_id.required' => 'Bạn chưa chọn nhóm thành viên.',
            'user_catalogue_id.gt' => 'Bạn chưa chọn nhóm thành viên.',
        ];
    }
}