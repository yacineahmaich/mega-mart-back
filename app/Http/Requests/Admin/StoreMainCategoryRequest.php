<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMainCategoryRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }


  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'min:4', 'max:200', 'unique:main_categories'],
      'description' => ['nullable', 'string', "max:500"],
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
