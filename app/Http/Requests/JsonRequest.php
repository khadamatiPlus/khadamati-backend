<?php

namespace App\Http\Requests;

use App\Enums\Core\ErrorTypes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class JsonRequest extends FormRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::GENERAL;

    public function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->keys() as $error){
            array_push($errors, ['key' => $error, 'error' => $validator->errors()->get($error)[0]]);
        }
        $errorType = (ErrorTypes::isValidValue($this->errorType))?$this->errorType:ErrorTypes::GENERAL;
        throw new HttpResponseException(response()->json(['error_type' => $errorType, 'errors' => $errors], 400, [], JSON_UNESCAPED_SLASHES));
    }
}
