<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title' => 'required|max:70',
      'description' => 'required',
      'tags' => ['array'],
      'category.value' => [
        'bail',
        'nullable',
        Rule::exists(Category::class, 'id'),
      ],
    ];
  }
}
