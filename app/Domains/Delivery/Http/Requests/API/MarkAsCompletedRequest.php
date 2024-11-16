<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Domains\Delivery\Models\Order;
use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class MarkAsCompletedRequest extends JsonRequest
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
        return auth()->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => ['required', Rule::in(Order::query()->where('customer_id','=',auth()->user()->customer_id)->pluck('id'))]
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
