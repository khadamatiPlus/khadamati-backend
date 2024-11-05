<?php

namespace App\Domains\Auth\Http\Requests\API;

use App\Domains\Auth\Models\User;
use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/15/2022
 * Class: MerchantBranchAccessActivationRequest.php
 */
class MerchantBranchAccessActivationRequest extends JsonRequest
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
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id', Rule::in(User::query()->where('merchant_id','=',$this->user()->merchant_id)->pluck('id'))],
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
