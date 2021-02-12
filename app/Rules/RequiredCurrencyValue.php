<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredCurrencyValue implements Rule
{
    private $otherInput;
    private $requiredValue;

    /**
     * Create a new rule instance.
     *
     * @param string $otherInput
     * @param string $requiredValue
     */
    public function __construct(string $otherInput, string $requiredValue)
    {
        $this->otherInput = $otherInput;
        $this->requiredValue = $requiredValue;
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
        return (request()->get($this->otherInput) == $this->requiredValue) ||
            $value == $this->requiredValue;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.required_currency_value', ['req_val' => $this->requiredValue]);
    }
}
