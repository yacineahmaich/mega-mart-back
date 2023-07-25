<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->category
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:200'],
            'description' => ['nullable', 'string', "max:500"],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            'images.*' => ['image']
        ];
    }

    public function messages()
    {
        return [
            'images.*.image' => 'image (:position) not a valid image !'
        ];
    }
}
