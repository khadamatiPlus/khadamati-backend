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
            'mobile_number' => $merchant->profile->mobile_number,
            'email' => $merchant->profile->email,
            'name' => $merchant->name,
            'city_id' => $merchant->city_id,
            'country_id' => $merchant->country_id,
            'area_id' => $merchant->area_id,
            'city_name' => $merchant->city->name,
            'country_name' => $merchant->country->name,
            'area_name' => $merchant->area->name,
            'longitude' => $merchant->longitude,
            'latitude' => $merchant->latitude,
            'profile_pic' => !empty($merchant->profile_pic)?storageBaseLink(StoragePaths::MERCHANT_PROFILE_PIC.$merchant->profile_pic):'',
        ];
    }
}
