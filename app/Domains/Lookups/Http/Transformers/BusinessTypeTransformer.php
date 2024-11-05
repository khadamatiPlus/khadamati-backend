<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\BusinessType;
use App\Enums\Core\StoragePaths;


/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 3/7/2022
 * Class: VehicleTypeTransformer.php
 */
class BusinessTypeTransformer
{

    /**
     * @param BusinessType $businessType
     * @return array
     */
    public function transform(BusinessType $businessType): array
    {
        return [
            'id' => $businessType->id,
            'name' => $businessType->name,
//            'image' => !empty($businessType->image)?storageBaseLink(StoragePaths::USER_TYPE_IMAGE.$businessType->image):'',

        ];
    }
}
