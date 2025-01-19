<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends ValidationException
{
    public $validator;
    public $index;
    public function __construct(Validator $validator, $index = 3)
    {
        $this->validator = $validator;
        $this->index = $index;
    }

    public function render($request)
    {
        $errors = $this->validator->errors();
        $formattedErrors = [];
        foreach ($errors->getMessages() as $key => $messages) {
            foreach ($messages as $message) {
                $formattedErrors[] = [
                    'field' => $key, 
                    'messagesss' => $message,
                    'index' => 3
                ];
            }
        }
        return response()->json(['message' => 'Errores de validación', 'errors123' => $formattedErrors], 422);
    }
}
