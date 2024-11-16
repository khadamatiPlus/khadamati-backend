<?php

namespace App\Domains\Delivery\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 6/4/2023
 * Class: DeliveryWalletRequest.php
 */
class DeliveryWalletRequest  extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->isDeliveryAdmin() || $this->user()->hasAllAccess();
    }
    /**
     * @param Request $request
     * @return \string[][]
     */
    public function rules(Request $request): array
    {
        return [];
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

