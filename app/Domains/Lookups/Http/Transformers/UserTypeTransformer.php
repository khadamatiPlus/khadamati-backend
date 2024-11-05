<?php

namespace App\Domains\Lookups\Http\Transformers;
use App\Domains\Lookups\Models\UserType;
use App\Enums\Core\StoragePaths;

class UserTypeTransformer
{
    /**
     * @param UserType $userTypee
     * @return array
     */
    public function transform(UserType $userType): array
    {
        return [
            'id' => $userType->id,
            'name' => $userType->name,
            'image' => !empty($userType->image)?storageBaseLink(StoragePaths::USER_TYPE_IMAGE.$userType->image):'',

        ];
    }
}
