<?php

namespace App\Domains\Service\Http\Transformers;

use App\Domains\Service\Models\Service;
use App\Enums\Core\StoragePaths;
use Illuminate\Support\Carbon;

class ServiceTransformer
{


    public function transform(Service $service): array
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'price' => $service->price,
            'tags' => $service->tags->pluck('name'), // Assuming tags are related via many-to-many
            'images' => ($service->images ?? collect())->map(function ($image) {
                return [
                    'image' => $image->image,
                    'is_main' => $image->is_main,
                ];
            }),
            'products' => ($service->products ?? collect())->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'description' => $product->description,
                ];
            }),
        ];
    }

}
