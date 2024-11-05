<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\City;

class CityTransformer
{
    public function transform(City $city): array
    {
        return [
            'id' => $city->id,
            'name' => $city->name,
        ];
    }
}
