<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'product_id' => $this->product
        ]);
    }

    public function rules(): array
    {
        return [
            'end' => ["required", 'date', 'after_or_equal:tomorrow'],
            'backdrop' => ["required", 'image'],
            'product_id' => ["required", 'exists:products,id']
        ];
    }

    public function messages()
    {
        return [
            'backdrop' => 'backdrop image not a valid image !'
        ];
    }
}
