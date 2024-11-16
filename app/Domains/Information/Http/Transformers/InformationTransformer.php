<?php

namespace App\Domains\Information\Http\Transformers;
use App\Domains\Information\Models\Information;


class InformationTransformer
{

    /**
     * @param Information $information
     * @return array
     */
    public function transform(Information $information): array
    {
        return [
//            'id' => $information->id,
            'email' => $information->email,
            'phone_number' => $information->phone_number,
            'second_phone_number' => $information->second_phone_number,

        ];
    }
}
