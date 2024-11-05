<?php

namespace App\Domains\Customer\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\StorageManagerService;
class CustomerRequest extends FormRequest
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
                            return $query->whereNotNull('captain_id');
                        }),
                        'regex:/^7[789]\\d{7}$/'
                    ],
                    'name' => ['required', 'max:350'],
                    'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:customers,id'],
                    'name' => ['required', 'max:350'],
                    'profile_pic' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedImages)],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:customers,id']
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

