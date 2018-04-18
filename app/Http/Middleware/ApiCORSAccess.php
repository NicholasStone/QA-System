<?php

namespace App\Http\Middleware;

use Closure;

class ApiCORSAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $allow_origins = [
            config('api.domain'),
            config('app.url'),
            'http://localhost:8080'
        ];
        $origin = $request->server('HTTP_ORIGIN');
        \Debugbar::addMessage('HTTP_ORIGIN = ' . $origin);
        if (in_array($origin, $allow_origins)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
            $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}
