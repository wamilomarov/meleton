<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use App\Rules\RequiredCurrencyValue;
use App\Rules\ValidCurrency;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ConvertRequest extends FormRequest
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
            'currency_from' => [
                'required',
                'string',
                new ValidCurrency(),
                new RequiredCurrencyValue('currency_to', 'BTC')
            ],
            'currency_to' => [
                'required',
                'string',
                new ValidCurrency(),
                new RequiredCurrencyValue('currency_from', 'BTC')
            ],
            'value' => [
                'required',
                'numeric',
                'gte:1'
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator);
    }
}
