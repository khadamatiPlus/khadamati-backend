<?php

namespace App\Domains\Banner\Http\Transformers;

use App\Domains\Banner\Models\Banner;
use App\Enums\Core\StoragePaths;
use Illuminate\Support\Facades\Log;


class BannerTransformer
{
    /**
     * @param Banner $notification
     * @return array
     */
    public function transform(Banner $banner): array
    {
        return [
            'id' => $banner->id,
             'title' =>  $banner->title,
            'banner' => !empty($banner->image)?storageBaseLink(StoragePaths::BANNER_IMAGE.$banner->image):'',
        ];
    }
}
