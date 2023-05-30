<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(){
        $this->merge([
            'category_id' => $this->category
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:200'],
            'description' => ['nullable', 'string',"max:500"],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            // 'images' => ['required', 'min:1'],
            // 'images.*' => [
            //     'image',
            //     'mimes:jpeg,jpg,png',
            //     //  'max:2048',
            //     //  'dimensions:min_width=600,min_height=600,max_width=800,max_height=800'
            //      ]
        ];
    }
}
