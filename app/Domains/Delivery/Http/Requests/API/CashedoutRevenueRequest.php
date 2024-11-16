<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;

/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 4/25/2022
 * Class: CashedoutRevenueRequest.php
 */
class CashedoutRevenueRequest extends JsonRequest
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
        return auth()->user()->isMerchantAdmin() || auth()->user()->isMerchantBranchAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
