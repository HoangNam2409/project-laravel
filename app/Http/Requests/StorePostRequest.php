<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'name' => 'required',
            'canonical' => 'required|unique:routers,canonical',
            'post_catalogue_id' => 'gt:0',
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => 'Bạn chưa nhập tiêu đề.',
            'canonical.required' => 'Bạn chưa nhập đường dẫn.',
            'canonical.unique' => 'Đường dẫn đã tồn tại.',
            'post_catalogue_id.gt' => 'Bạn phải chọn danh mục cha.'
        ];
    }
}