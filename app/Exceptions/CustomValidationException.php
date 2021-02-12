<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class CustomValidationException extends Exception
{
    public $status = 403;

    public function __construct(Validator $validator, $response = null, $errorBag = 'default')
    {
        parent::__construct($validator->errors()->first());
    }

    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @param string $message
     * @return static
     */
    public static function withMessage(string $message): CustomValidationException
    {
        return new static(tap(ValidatorFacade::make([], []), function ($validator) use ($message) {
            $validator->errors()->add('message', $message);
        }));
    }


}
