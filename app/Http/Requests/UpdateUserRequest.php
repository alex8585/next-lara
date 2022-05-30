<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
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
    $user = $this->route('user');

    return [
      'name' => ['required', 'max:50'],
      'email' => [
        'required',
        'max:50',
        'email',
        Rule::unique('users')->ignore($user->id),
      ],
      'password' => ['required', Rules\Password::defaults()],
    ];
  }
}
