<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMainCategoryRequest extends FormRequest
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
      'name' => ['required', 'string', 'min:4', 'max:200'],
      'description' => ['nullable', 'string', "max:500"],
      'image' => ['image', 'mimes:jpeg,jpg,png'],
    ];
  }

  public function messages()
  {
    return [
      'image.mimes' => 'bad image provided! please read the notes below',
      'image.image' => 'image must be a valid image'
    ];
  }
}