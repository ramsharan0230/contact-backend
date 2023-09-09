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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Define the allowed origins (trusted domains)
        $allowedOrigins = [
            'http://localhost:8080',
            'http://localhost:8000',
        ];

        $origin = $request->header('Origin');

        if (in_array($origin, $allowedOrigins)) {
            // Set the Access-Control-Allow-Origin header to the allowed origin
            $response = $next($request)
                ->header('Access-Control-Allow-Origin', "*")
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

            // Check for preflight (OPTIONS) requests and handle them
            if ($request->isMethod('OPTIONS')) {
                return $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            }

            return $response;
        }

        return $next($request);
    }
}
