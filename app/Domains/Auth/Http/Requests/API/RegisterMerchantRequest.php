<?php

namespace App\Domains\Auth\Http\Requests\API;
use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

class RegisterMerchantRequest extends JsonRequest
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
                    return $query->whereNotNull('merchant_id');
                }),
                'regex:/^7[789]\\d{7}$/'
            ],
            'name' => ['required', 'max:350'],
            'latitude' => ['nullable', 'max:350'],
            'longitude' => ['nullable', 'max:350'],
            'business_type_id' => ['required','exists:business_types,id'],
            'city_id' => ['required','exists:cities,id'],
            'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
            'firebase_auth_token' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'country_code.unique' => __('Mobile number is already registered'),
            'name.unique' => __('The store name is not available'),
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
