<?php

namespace App\Http\Middleware\Front;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['en', 'uk'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, self::SUPPORTED)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        $request->route()?->forgetParameter('locale');

        return $next($request);
    }
}
