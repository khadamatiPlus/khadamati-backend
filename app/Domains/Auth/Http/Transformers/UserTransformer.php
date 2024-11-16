<?php

namespace App\Domains\Auth\Http\Transformers;

use App\Domains\Auth\Models\User;


class UserTransformer
{

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'type' => $user->getUserType(),
            'country_code' => $user->country_code,
            'mobile_number' => $user->mobile_number,
            'email' => $user->email,
//            'locale' => $user->locale,
//            'app_notification' => $user->app_notification,
            'active' => $user->active,
        ];
    }
}
