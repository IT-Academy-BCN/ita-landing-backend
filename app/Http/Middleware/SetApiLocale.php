<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetApiLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language');

        $supportedLocales = config('translatable.locales');
        if (!in_array($locale, $supportedLocales)) {
            
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
