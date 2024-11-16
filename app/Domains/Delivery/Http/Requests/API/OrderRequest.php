<?php

namespace App\Domains\Delivery\Http\Requests\API;

use App\Domains\Merchant\Models\MerchantBranch;
use App\Enums\Core\ErrorTypes;
use App\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends JsonRequest
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
            'customer_name' => ['required', 'max:350'],
            'customer_phone' => ['required', 'max:350'],
            'city_id' => ['required', 'integer'],
            'address_info' => ['required', 'max:350'],
            'street_info' => ['nullable', 'max:350'],
            'building_number' => ['nullable', 'max:350'],
            'floor' => ['nullable', 'max:350'],
            'order_amount' => ['required','numeric', 'min:0.1','max:999999999.999'],
            'order_reference' => ['required', 'max:350', 'unique_multiple:orders,merchant_branch_id,order_reference'],
            'payment_type' => ['required', 'integer', Rule::in([1,2])],
            'merchant_branch_id' => ['required', 'integer', $this->user()->isMerchantAdmin()?Rule::in(MerchantBranch::query()->where('merchant_id',$this->user()->merchant_id)->pluck('id')):Rule::in($this->user()->merchant_branch_id)],
            'with_captain' => ['required', 'in:true,false']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'order_reference.unique_multiple' => __('Order reference is already taken')
        ];
    }
}
