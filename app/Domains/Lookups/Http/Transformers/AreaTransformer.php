<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\Area;

class AreaTransformer
{
    public function transform(Area $area): array
    {
        return [
            'id' => $area->id,
            'name' => $area->name,
        ];
    }
}
