<?php

namespace App\Domains\Auth\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 6/8/2022
 * Class: RegisterCustomerRequest.php
 */
class RegisterCustomerRequest extends JsonRequest
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
            'mobile_number' => ['required', Rule::unique('users')],
            'country_code'=> ['required'],
            'first_name' => ['nullable', 'max:350'],
            'last_name' => ['nullable', 'max:350'],
            'profile_pic' => ['nullable'],
            'dob' => ['required', 'date'],
            'latitude'  =>  'nullable|numeric|between:-90,90',
            'longitude' =>  'nullable|numeric|between:-180,180',
            'gender' => ['required', 'in:1,2'],
            'email' => ['nullable', 'email',Rule::unique('users'),Rule::unique('customers')],
            'firebase_auth_token' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
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
