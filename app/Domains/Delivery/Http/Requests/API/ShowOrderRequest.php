<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/17/2022
 * Class: ShowOrderRequest.php
 */
class ShowOrderRequest extends JsonRequest
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
        return auth()->user()->isMerchantAdmin() || auth()->user()->isCaptain();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => ['required','exists:orders,id']
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
