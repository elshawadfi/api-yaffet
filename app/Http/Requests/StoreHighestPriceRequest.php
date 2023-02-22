<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHighestPriceRequest extends FormRequest
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
            'metal_code' => 'required|string|max:5',
            'price'      => 'required',
            'unit'       => ['required', Rule::in(['gram', 'ounce'])],
            'currency'   => 'required|string',
            'price_date' => 'required|date',
        ];
    }
}
