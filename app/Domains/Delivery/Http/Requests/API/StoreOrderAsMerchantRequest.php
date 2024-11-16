<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

class StoreOrderAsMerchantRequest extends JsonRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::ORDER;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'delivery_destination' => ['required'],
            'city_id' => ['required'],
            'vehicle_type_id' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'is_instant_delivery' => ['required'],
            'order_amount' => ['required'],
            'delivery_amount' => ['required'],
            'customer_phone' => ['required'],
            'notes' => ['nullable'],
            'latitude_to' => ['nullable'],
            'longitude_to' => ['nullable'],
            'voice_record' => ['nullable', 'mimes:'.implode(',',StorageManagerService::$allowedAudios)]
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
