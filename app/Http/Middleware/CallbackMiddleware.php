<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CallbackMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->input('secret') !== env('VK_SECRET_KEY')) {
            abort(401);
        }

        return $next($request);
    }
}
