<?php

namespace App\Domains\Merchant\Http\Requests\Backend;

use App\Domains\Auth\Models\User;
use App\Domains\Merchant\Models\Merchant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;
;

/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 3/9/2022
 * Class: CashoutTransactionRequest.php
 */
class MerchantRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        switch ($request->method()) {
            case self::METHOD_POST:
                return [
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->where(function ($query) {
                            return $query->whereNotNull('merchant_id');
                        }),
                        'regex:/^7[789]\\d{7}$/'
                    ],
                    'email' => [
                        'required','email',
                        Rule::unique('users')->where(function ($query) {
                            return $query->whereNotNull('merchant_id');
                        })
                    ],
                    'name' => ['required', 'max:350'],
                    'country_id' => ['required','exists:countries,id'],
                    'city_id' => ['required','exists:cities,id'],
                    'area_id' => ['required','exists:areas,id'],
                    'is_verified' => ['sometimes','in:0,1'],
                    'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                    'latitude' => ['required', 'max:350'],
                    'longitude' => ['required', 'max:350'],
                    'password' => ['required', 'confirmed'],

                ];
            case self::METHOD_PATCH:
                \Log::info('merchant update:'.$this->owner_id);
                return [
                    'id' => ['required', 'exists:merchants,id'],
                    'name' => ['required', 'max:350'],
                    'country_id' => ['required','exists:countries,id'],
                    'city_id' => ['required','exists:cities,id'],
                    'area_id' => ['required','exists:areas,id'],
                    'is_verified' => ['sometimes','in:0,1'],
                    'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                    'latitude' => ['required', 'max:350'],
                    'longitude' => ['required', 'max:350'],
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($this->owner_id)->where(function ($query) {
                            return $query->whereNotNull('merchant_id');
                        })
                    ],
                    'mobile_number' => [
                        'required',
                        Rule::unique('users')->ignore($this->owner_id)->where(function ($query) {
                            return $query->whereNotNull('merchant_id');
                        }),
                        'regex:/^7[789]\\d{7}$/'
                    ],
                    'password' => ['nullable', 'confirmed'],

                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:merchants,id']
                ];
        }
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'country_code.unique' => __('Mobile number is already registered'),
            'name.unique' => __('The store name is not available'),
            'name_ar.unique' => __('The store name (Arabic) is not available'),

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

