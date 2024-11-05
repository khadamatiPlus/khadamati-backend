<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OptionalAuthSanctum
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            $user = Auth('sanctum')->user();
            Auth::setUser($user);
            $request->setUserResolver(function () use ($user){
               return $user;
            });
        }

        return $next($request);
    }
}
