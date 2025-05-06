<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
            'password' => 'required|string|min:6',
            're_password' => 'required|string|same:password',
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
            'password.required' => 'Bạn chưa nhập vào mật khẩu.',
            'password.min' => 'Mật khẩu của bạn không được chứa tối thiểu 6 ký tự.',
            're_password.same' => 'Mật khẩu không khớp.',
        ];
    }
}