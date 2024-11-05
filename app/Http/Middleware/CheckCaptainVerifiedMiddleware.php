<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 9/22/2022
 * Class: CheckCaptainVerifiedMiddleware.php
 */
class CheckCaptainVerifiedMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(empty(auth()->user()->captain) || !auth()->user()->captain->is_verified){
            throw new UnauthorizedException(403,__('Your Captain profile should be verified by :app_name Administrator',['app_name' => appName()]));
        }

        return $next($request);
    }
}
