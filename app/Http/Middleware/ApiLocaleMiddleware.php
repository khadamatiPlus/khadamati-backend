<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Locale is enabled and allowed to be changed
        if(!$request->hasHeader("Accept-Language")){
            $request->headers->set('Accept-Language',env('DEFAULT_LOCALE','en'));
        }
        if (config('boilerplate.locale.status')) {
            setAllLocale($request->header("Accept-Language"));
        }
        return $next($request);
    }
}
