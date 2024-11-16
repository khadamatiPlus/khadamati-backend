<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class CalculateDeliveryAmountRequest extends JsonRequest
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
//            'customer_address_id' => ['required', 'integer', Rule::in(auth()->user()->customer->customerAddresses()->pluck('id'))],
            'latitude' => ['required', 'max:350'],
            'longitude' => ['required', 'max:350'],
            'merchant_branch_id' => ['required', 'integer'],
            'item_id' => ['required', 'integer'],
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
