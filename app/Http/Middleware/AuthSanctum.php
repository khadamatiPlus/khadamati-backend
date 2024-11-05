<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSanctum
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            $user = Auth('sanctum')->user();
            if(!empty($user))
            {
                Auth::setUser($user);
                $request->setUserResolver(function () use ($user){
                    return $user;
                });
                return $next($request);
            }
            else{
                throw new AuthenticationException();
            }
        }
        else{
            throw new AuthenticationException();
        }
    }
}
