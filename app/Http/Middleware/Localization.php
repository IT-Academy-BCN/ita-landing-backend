<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userLanguage = $request->header('accept-language');

        Session::put('language', $userLanguage);

        \View::share('t', function ($key) {


           
                App::setLocale($request->header("Accept-Language"));
            
            return $key;
        });

        return $next($request);
    }
}