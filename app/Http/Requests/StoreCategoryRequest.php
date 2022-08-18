<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Facades\TransHelp;

class StoreCategoryRequest extends FormRequest
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
        $fields =[
          'name' => 'required|max:70',
        ];

        $validatorData = TransHelp::getValidatorFields($fields);
        return $validatorData;
    }
}
