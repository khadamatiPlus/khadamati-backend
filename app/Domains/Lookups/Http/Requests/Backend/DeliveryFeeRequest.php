<?php
namespace App\Domains\Lookups\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DeliveryFeeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Request $request
     * @return \string[][]
     */
    public function rules(Request $request): array
    {
        switch ($request->method()) {
            case self::METHOD_POST:
                return [
                    'amount' => ['required', 'max:255', 'unique:delivery_fees,amount'],                ];
            case self::METHOD_PATCH:
                return [
                    'id' => ['required', 'exists:delivery_fees,id'],
                    'amount' => ['required', 'max:255', 'unique:delivery_fees,amount,' . $this->id],
                ];
            case self::METHOD_DELETE:
            default:
                return [
                    'id' => ['required', 'exists:delivery_fees,id']
                ];
        }
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }
}


