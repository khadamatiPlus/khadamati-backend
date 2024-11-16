<?php

namespace App\Domains\Lookups\Http\Transformers;

use App\Domains\Lookups\Models\Category;

class CategoryTransformer
{

    public function transform(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'sub_categories' => $category->children ? $category->children->transform(function ($subCategory) {
                return [
                    'id' => $subCategory->id,
                    'name' => $subCategory->name
                ];
            }) : []
        ];
    }

}
