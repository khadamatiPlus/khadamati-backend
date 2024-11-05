<?php

namespace App\Domains\Merchant\Models\Traits\Scope;


use Illuminate\Support\Carbon;

trait MerchantScope
{

    public function scopeNewOnPlatform($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays(6)->toDateTimeString());
    }
}
