<?php

namespace App\Domains\Introduction\Http\Transformers;

use App\Domains\Introduction\Models\Introduction;
use App\Enums\Core\StoragePaths;
use Illuminate\Support\Facades\Log;


class IntroductionTransformer
{

    public function transform(Introduction $introduction): array
    {
        return [
            'id' => $introduction->id,
             'title' =>  $introduction->title,
            'image' => !empty($introduction->image)?storageBaseLink(StoragePaths::INTRODUCTION_IMAGE.$introduction->image):'',
        ];
    }
}
