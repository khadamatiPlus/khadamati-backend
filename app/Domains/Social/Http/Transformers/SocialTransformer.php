<?php

namespace App\Domains\Social\Http\Transformers;
use App\Domains\Social\Models\Social;


class SocialTransformer
{

    /**
     * @param Social $social
     * @return array
     */
    public function transform(Social $social): array
    {
        return [
//            'id' => $social->id,
//            'x' => $information->x,
//            'whatsapp' => $information->whatsapp,
//            'youtube' => $information->youtube,
//            'tiktok' => $information->tiktok,
//            'snapchat' => $information->snapchat,
            'facebook' => $social->facebook,
            'instagram' => $social->instagram,

        ];
    }
}
