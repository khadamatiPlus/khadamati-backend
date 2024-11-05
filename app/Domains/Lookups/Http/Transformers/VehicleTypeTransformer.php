<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\VehicleType;

class VehicleTypeTransformer
{

    /**
     * @param VehicleType $vehicleType
     * @return array
     */
    public function transform(VehicleType $vehicleType): array
    {
        return [
            'id' => $vehicleType->id,
            'name' => $vehicleType->name
        ];
    }
}
