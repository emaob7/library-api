<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
                'error' => 'Missing or invalid authentication token'
            ], 401);
        }

        return $next($request);
    }
}