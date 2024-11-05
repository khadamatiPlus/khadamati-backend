<?php

namespace App\Models\Traits\Scopes;

trait HasLocalizableAttributes
{

    public function getAttribute($key)
    {
        $attribute = parent::getAttribute($key);
        if(app()->getLocale() != 'en'){
            $localized_key = $key.'_'.app()->getLocale();
            if(array_key_exists($localized_key,$this->attributes)){
                $localized_val = parent::getAttribute($localized_key);
                if(!empty($localized_val)){
                    $attribute = $localized_val;
                }
            }
        }
        return $attribute;
    }
}
