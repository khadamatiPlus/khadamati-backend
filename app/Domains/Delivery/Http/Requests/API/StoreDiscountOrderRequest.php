<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Enums\Core\PaymentTypes;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class StoreDiscountOrderRequest extends JsonRequest
{
    /**
     * @var int $errorType
     */
    protected int $errorType = ErrorTypes::ITEM;

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
            'merchant_branch_id' => ['required', 'integer','exists:merchant_branches,id'],
            'pin_code' => ['required'],
            'price' => ['required'],
            'discount_id' => ['required', 'integer', 'exists:discounts,id'],

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
