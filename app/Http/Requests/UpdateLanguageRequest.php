<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
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
            'name' => 'required|string',
            'canonical' => 'required|string|unique:languages,canonical, ' . $this->id . ',id',
        ];
    }

    public function messages(): array
    {
        return  [
            'name.required' => 'Bạn chưa nhập vào tên ngôn ngữ.',
            'canonical.required' => 'Bạn chưa nhập vào tên đường dẫn.',
            'canonical.unique' => 'Canonical đã tồn tại.',
        ];
    }
}
