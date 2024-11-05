<?php

namespace App\Domains\Merchant\Http\Transformers;

use App\Domains\Delivery\Models\Order;
use App\Domains\Merchant\Models\Merchant;
use App\Enums\Core\StoragePaths;
use Illuminate\Support\Carbon;

class MerchantTransformer
{

    /**
     * @param Merchant $merchant
     * @return array
     */
    public function transform(Merchant $merchant): array
    {
        return [
            'id' => $merchant->id,
            'name' => $merchant->name,
            'business_type_id' => $merchant->business_type_id,
            'business_type_name' => $merchant->businessType->name,
            'city_id' => $merchant->city_id,
            'city_name' => $merchant->city->name,
            'longitude' => $merchant->longitude,
            'latitude' => $merchant->latitude,
            'profile_pic' => !empty($merchant->profile_pic)?storageBaseLink(StoragePaths::MERCHANT_PROFILE_PIC.$merchant->profile_pic):'',
        ];
    }
}
