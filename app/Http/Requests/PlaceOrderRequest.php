<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cart' => ['required', 'min:1'],
            'delivery' => ['required'],
            'delivery.email' => ['required', 'email'],
            'delivery.name' => ['required', 'string'],
            'delivery.phone' => ['required', 'numeric', 'digits:10'],
            'delivery.note' => ['required'],
            'delivery.shippingAddress' => ['required'],
        ];
    }
}
