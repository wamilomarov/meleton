<?php

namespace App\Rules;

use App\Models\Rate;
use Illuminate\Contracts\Validation\Rule;

class ValidCurrency implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value == 'BTC' || Rate::query()->where('currency', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.wrong_currency');
    }
}
