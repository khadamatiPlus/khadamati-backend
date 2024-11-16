<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Enums\Core\OrderActions;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class OrderActionByMerchantRequest extends JsonRequest
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
            'order_id' => ['required','exists:recents,id'],
            'action_id' => ['required']
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
