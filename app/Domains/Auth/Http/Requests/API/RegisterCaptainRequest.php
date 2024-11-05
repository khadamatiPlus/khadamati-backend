<?php

namespace App\Domains\Auth\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/14/2022
 * Class: RegisterCaptainRequest.php
 */
class RegisterCaptainRequest extends JsonRequest
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
            'mobile_number' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNotNull('captain_id');
                }),
                'regex:/^7[789]\\d{7}$/'
            ],
            'name' => ['required', 'max:350'],
            'vehicle_type_id' => ['required','exists:vehicle_types,id'],
            'is_instant_delivery' => ['sometimes'],
            'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
            'driving_license_card' => [
                'nullable',
                'mimes:'.implode(',', array_merge(StorageManagerService::$allowedFiles, StorageManagerService::$allowedImages)),
                'required_without_all:car_id_card' // This makes 'driving_license_card' required when 'car_id_card' is empty
            ],
            'car_id_card' => [
                'nullable',
                'mimes:'.implode(',', array_merge(StorageManagerService::$allowedFiles, StorageManagerService::$allowedImages)),
                'required_without_all:driving_license_card' // This makes 'car_id_card' required when 'driving_license_card' is empty
            ],

            'cities' => ['nullable'],
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
