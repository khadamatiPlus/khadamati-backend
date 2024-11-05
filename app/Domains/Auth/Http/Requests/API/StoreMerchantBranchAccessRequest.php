<?php

namespace App\Domains\Auth\Http\Requests\API;

use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use App\Services\StorageManagerService;
use Illuminate\Validation\Rule;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/8/2022
 * Class: RegisterMerchantRequest.php
 */
class StoreMerchantBranchAccessRequest extends JsonRequest
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
    public function authorize()
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
            'mobile_number' => ['required', Rule::unique('users')],
            'name' => ['required', 'max:350'],
            'merchant_branch_id' => ['required', 'exists:merchant_branches,id', Rule::in($this->user()->merchant->merchantBranches()->pluck('id'))]
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
    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance(): \Illuminate\Contracts\Validation\Validator
    {
        $this->mobileNumberFormat();

        return parent::getValidatorInstance();
    }

    /**
     * @return void
     */
    protected function mobileNumberFormat()
    {
        $this->request->set('mobile_number',(int)$this->request->get('mobile_number'));
    }
}
