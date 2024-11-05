<?php

namespace App\Domains\Merchant\Http\Requests\API;

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
            'name' => !empty($this->name)?['sometimes', 'max:400']:'',
            'latitude' => !empty($this->latitude)?['sometimes', 'max:400']:'',
            'longitude' => !empty($this->longitude)?['sometimes', 'max:400']:'',
            'city_id' => !empty($this->city_id)?['sometimes','exists:cities,id']:'',
            'business_type_id' => !empty($this->city_id)?['sometimes','exists:business_types,id']:'',
            'profile_pic' => !empty($this->profile_pic)?['sometimes', 'mimes:'.implode(',',StorageManagerService::$allowedImages)]:'',
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
