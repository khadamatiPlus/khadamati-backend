<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Framework');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     * @return Carbon
     *
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.index';
    }
}

if(! function_exists('normalizeToUser')){
    /**
     * Return basic user object for non-registered email address
     *
     * @param $email
     * @return object
     */
    function normalizeToUser($email): object
    {
        return (object) [
            'email' => $email,
            'name' => substr($email, 0, strpos($email, '@'))
        ];
    }
}

if(! function_exists('toStrValArr')){
    /**
     * This method takes array of anything and return it back with string cast values
     *
     * @param array $arr
     * @return array
     */
    function toStrValArr(array $arr): array
    {
        return array_map('strval', $arr);
    }
}

if(!function_exists('storageBaseLink')){
    /**
     * This method will return the storage base url where the media files is stored
     *
     * @param $media
     * @return string
     */
    function storageBaseLink($media): string
    {
        return env('STORAGE_BASE_LINK', url()->to('/')).'/'.$media;
    }
}

if(!function_exists('cleanStr')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function cleanStr($str): string
    {
        return str_replace(' ', '-', $str); // Replaces all spaces with hyphens.
    }
}
if(!function_exists('getCaptainsCount')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function getCustomersCount(): string
    {
        return \App\Domains\Customer\Models\Customer::query()->count(); // Replaces all spaces with hyphens.
    }


}
if(!function_exists('getMerchantsCount')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function getMerchantsCount(): string
    {
        return \App\Domains\Merchant\Models\Merchant::query()->count(); // Replaces all spaces with hyphens.
    }


}
if(!function_exists('getCaptainTotalDeliveryAmount')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function getCaptainTotalDeliveryAmount($captainId): string
    {
        return  \App\Domains\Delivery\Models\Order::query()->where('captain_id',$captainId)->where('status',\App\Enums\Core\OrderStatuses::COMPLETED)->sum('delivery_amount');
    }

}
if(!function_exists('getCaptainTotalOrderAmount')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function getCaptainTotalOrderAmount($captainId): string
    {
        return  \App\Domains\Delivery\Models\Order::query()->where('captain_id',$captainId)->where('status',\App\Enums\Core\OrderStatuses::COMPLETED)->sum('order_amount');
    }

}
if(!function_exists('getCaptainTotalCompletedOrders')){
    /**
     * This method can be used to clean the string from spaces and special characters
     *
     * @param $str
     * @return string
     */
    function getCaptainTotalCompletedOrders($captainId): string
    {
        return  \App\Domains\Delivery\Models\Order::query()->where('captain_id',$captainId)->where('status',\App\Enums\Core\OrderStatuses::COMPLETED)->count();
    }

}
