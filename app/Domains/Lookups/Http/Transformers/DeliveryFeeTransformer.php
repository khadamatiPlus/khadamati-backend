<?php

namespace App\Domains\Lookups\Http\Transformers;
use App\Domains\Lookups\Models\DeliveryFee;

class DeliveryFeeTransformer
{

    /**
     * @param DeliveryFee $deliveryFee
     * @return array
     */
    public function transform(DeliveryFee $deliveryFee): array
    {
        return [
            'id' => $deliveryFee->id,
            'amount' => $deliveryFee->amount
        ];
    }
}
