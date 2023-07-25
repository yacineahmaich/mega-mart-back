<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'main_category_id' => $this->category
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:200', 'unique:categories'],
            'description' => ['nullable', 'string', "max:500"],
            'main_category_id' => ['required',  "exists:main_categories,id"],
            'image' => ['required', 'image'],
        ];
    }

    public function messages()
    {
        return [
            'image' => 'image not a valid image !'
        ];
    }
}
