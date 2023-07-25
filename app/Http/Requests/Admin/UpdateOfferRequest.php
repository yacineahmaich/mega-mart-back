<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'offer_end' => $this->end,
        ]);
    }

    public function rules(): array
    {
        return [
            'offer_end' => ["required", 'date', 'after_or_equal:start_date'],
            'backdrop' => ['image'],
        ];
    }

    public function messages()
    {
        return [
            'backdrop.image' => 'backdrop image not a valid image !'
        ];
    }
}
