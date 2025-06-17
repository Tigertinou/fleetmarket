<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('lang', config('app.locale'));
        session(['locale' => $locale]);
        app()->setLocale($locale);

        return $next($request);
    }
}
