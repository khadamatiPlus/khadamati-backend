<?php

namespace App\Domains\Auth\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/8/2022
 * Class: MobileAuthenticateRequest.php
 */
class MobileAuthenticateRequest extends JsonRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::AUTH;

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
            'country_code' => ['nullable', 'string'],
            'mobile_number' => ['required'],
            'firebase_auth_token' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'firebase_auth_token.required' => __('It seems you didn\'t complete the OTP verification steps')
        ];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance(): \Illuminate\Contracts\Validation\Validator
    {
        $this->mobileNumberFormat();

        return parent::getValidatorInstance();
    }

    /**
     * @return void
     */
    protected function mobileNumberFormat()
    {
        $this->request->set('mobile_number',(int)$this->request->get('mobile_number'));
    }
}
