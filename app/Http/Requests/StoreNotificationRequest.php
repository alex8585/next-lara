<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Facades\TransHelp;
use App\Models\Symbol;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest
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
            'price' => 'required|max:50',
            'symbol.value' => [
                'required',
                Rule::exists(Symbol::class, 'id'),

            ],
            'direction.value' => [
                'required'
            ]
        ];
    }
}
