<?php

namespace App\Auth\Presentation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        // Force Accept header to JSON
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        // Ensure response is JSON
        return $response;
    }
}