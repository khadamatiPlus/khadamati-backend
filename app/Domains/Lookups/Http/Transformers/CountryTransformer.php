<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\Country;

class CountryTransformer
{
    public function transform(Country $country): array
    {
        return [
            'id' => $country->id,
            'name' => $country->name,
            'phone_code' => $country->phone_code,
            'code' => $country->code,
        ];
    }

}
