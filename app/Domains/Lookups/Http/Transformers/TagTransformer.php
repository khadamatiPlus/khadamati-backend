<?php

namespace App\Domains\Lookups\Http\Transformers;
use App\Domains\Lookups\Models\Tag;

class TagTransformer
{

    public function transform(Tag $tag): array
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }
}
