<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\Label;
use App\Enums\Core\StoragePaths;

class LabelTransformer
{


    public function transform(Label $label): array
    {
        return [
            'id' => $label->id,
            'key' => $label->key,
            'value' => $label->value,

        ];
    }
}
