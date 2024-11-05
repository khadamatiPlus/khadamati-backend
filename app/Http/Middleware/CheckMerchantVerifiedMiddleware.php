<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/11/2022
 * Class: CheckMerchantVerifiedMiddleware.php
 */
class CheckMerchantVerifiedMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(empty(auth()->user()->merchant) || !auth()->user()->merchant->is_verified){
            throw new UnauthorizedException(403,__('Your merchant profile should be verified by :app_name Administrator',['app_name' => appName()]));
        }

        return $next($request);
    }
}
