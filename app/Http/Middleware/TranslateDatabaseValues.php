<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class TranslateDatabaseValues
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = App::getLocale();

        Builder::macro('translate', function ($column) use ($locale) {

            return $this->leftJoin("{$column}_translations as {$column}_translation", function ($join) use ($column, $locale) {

                $join->on("{$column}.id", '=', "{$column}_translation.{$column}_id")
                    ->where("{$column}_translation.locale", '=', $locale);

            })->addSelect("{$column}_translation.{$column}");
        });

        return $next($request);
    }
}
