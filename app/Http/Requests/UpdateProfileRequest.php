<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation() {
        $this->merge([
            'password_confirmation' => $this->passwordConfirmation
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
            "name" =>['required','string','min:4', 'max:50'],
            'email' => [
                'required', 'email',
                'unique:users,email,'.$this->user()->id
            ],
            'password' => [
                'confirmed',
                Password::min(6)->symbols()
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'this email has already an account'
        ];
    }
}
