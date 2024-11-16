<?php

namespace App\Domains\Lookups\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sub_categories' => CategoryResource::collection($this->subCategories)
        ];
    }
}

