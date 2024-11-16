<?php

namespace App\Domains\Merchant\Http\Requests\API;

use App\Domains\Lookups\Models\Area;
use App\Domains\Lookups\Models\City;
use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/11/2022
 * Class: UpdateMerchantRequest.php
 */
class UpdateMerchantRequest extends JsonRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::MERCHANT;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->isMerchantAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => !empty($this->name)?[
                'sometimes',
                'email',
                Rule::unique('users')->ignore($this->owner_id)->where(function ($query) {
                    return $query->whereNotNull('merchant_id');
                })
            ]:'',
            'name' => !empty($this->name)?['sometimes', 'max:400']:'',
            'latitude' => !empty($this->latitude)?['sometimes', 'max:400']:'',
            'longitude' => !empty($this->longitude)?['sometimes', 'max:400']:'',
            'profile_pic' => !empty($this->profile_pic)?['sometimes', 'mimes:'.implode(',',StorageManagerService::$allowedImages)]:'',

            'country_id' => !empty($this->country_id)?['required', 'exists:countries,id']:'',
            'city_id' =>!empty($this->city_id)? [
                'sometimes',
                'exists:cities,id',
                function ($attribute, $value, $fail) {
                    if (!City::where('id', $value)->where('country_id', request('country_id'))->exists()) {
                        $fail(__('The selected city does not belong to the chosen country.'));
                    }
                },
            ]:'',
            'area_id' => !empty($this->area_id)?[
                'sometimes',
                'exists:areas,id',
                function ($attribute, $value, $fail) {
                    // Check if the area belongs to the selected city
                    if (!Area::where('id', $value)->where('city_id', request('city_id'))->exists()) {
                        $fail(__('The selected area does not belong to the chosen city.'));
                    }
                },
            ]:'',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
