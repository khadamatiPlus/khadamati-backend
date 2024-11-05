<?php

namespace App\Domains\Captain\Models\Traits\Attribute;

use Illuminate\Support\Facades\Hash;

/**
 * Trait UserAttribute.
 */
trait CaptainAttribute
{

    /**
     * @return string
     */
    public function getCitiesLabelAttribute(): string
    {
        if (! $this->captainCities->count()) {
            return 'None';
        }

        $cites = $this->captainCities;
        $strings = '';
        foreach($cites as $index => $city)
        {
            if($index != 0){
                $strings = $strings.'<br />'.$city->city->name;
            }
            else{
                $strings = $strings.$city->city->name;
            }
        }
        return $strings;
    }
}
