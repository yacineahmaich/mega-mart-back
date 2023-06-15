<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'discount_start' => $this->start,
            'discount_end' => $this->end,
            'product_id' => $this->product
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
            'discount_start' => ['required', 'date', 'after_or_equal:now'],
            'discount_end' => ["required", 'date', 'after_or_equal:discount_start'],
            'percentage' => ["required", 'integer', 'min:1', 'max:100'],
            'product_id' => ["required", 'exists:products,id'],
        ];
    }
}
