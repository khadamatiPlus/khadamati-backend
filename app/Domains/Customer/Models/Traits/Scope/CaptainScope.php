<?php

namespace App\Domains\Captain\Models\Traits\Scope;


trait CaptainScope
{

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVerifiedOnly($query)
    {
        return $query->where('is_verified','=', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInstantOnly($query)
    {
        return $query->where('is_instant_delivery', '=', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotInstantOnly($query)
    {
        return $query->where('is_instant_delivery', '=', 0);
    }
}
