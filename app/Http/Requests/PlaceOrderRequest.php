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
            'delivery.phone' => ['required', 'numeric', 'regex:/^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/'],
            'delivery.note' => ['required'],
            'delivery.shippingAddress' => ['required'],
        ];
    }
}
