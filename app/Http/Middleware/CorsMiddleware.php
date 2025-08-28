<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('origin');

        $response = $next($request);

        if ($origin && (str_starts_with($origin, 'http://localhost:') || str_starts_with($origin, 'https://localhost:'))) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        return $response;
    }
}
