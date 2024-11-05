<?php

namespace App\Domains\Captain\Http\Transformers;

use App\Domains\Captain\Models\Captain;
use App\Domains\Captain\Models\CaptainCity;
use App\Enums\Core\StoragePaths;

class CaptainTransformer
{

    /**
     * @param Captain $captain
     * @return array
     */
    public function transform(Captain $captain): array
    {
        return [
            'id' => $captain->id,
            'name' => $captain->name,
            'status' => $captain->status,
            'latitude' => $captain->latitude ?? '',
            'longitude' => $captain->longitude ?? '',
            'vehicle_type_id' => $captain->vehicle_type_id,
            'vehicle_type_name' => $captain->vehicleType->name,
            'profile_pic' => !empty($captain->profile_pic)?storageBaseLink(StoragePaths::CAPTAIN_PROFILE_PIC.$captain->profile_pic):'',
            'driving_license_card' => !empty($captain->driving_license_card)?storageBaseLink(StoragePaths::CAPTAIN_DRIVING_LICENSE_CARD.$captain->driving_license_card):'',
            'car_id_card' => !empty($captain->car_id_card)?storageBaseLink(StoragePaths::CAPTAIN_CAR_ID_CARD.$captain->car_id_card):'',
            'total_delivery_amount'=>function_exists('getCaptainTotalDeliveryAmount') ?(int)getCaptainTotalDeliveryAmount($captain->id): 0,
            'completed_orders' => function_exists('getCaptainTotalCompletedOrders') ? (int)getCaptainTotalCompletedOrders($captain->id) : 0,
            'total_orders_amount'=>function_exists('getCaptainTotalOrderAmount') ? (int)getCaptainTotalOrderAmount($captain->id) : 0,
            'cities' => $captain->captainCities()->get()->transform(function (CaptainCity $captainCity){
                return [
                    'id' => $captainCity->city_id,
                    'name' => $captainCity->city->name
                ];
            })
        ];
    }
}
