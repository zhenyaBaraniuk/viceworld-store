<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartTokenCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user('customer')) {
            return $next($request);
        }

        $token = $request->cookie('cart_token') ?? (string) Str::uuid();
        $request->cookies->set('cart_token', $token);

        return $next($request)->withCookie(cookie('cart_token', $token, 60 * 24 * 30));
    }
}
