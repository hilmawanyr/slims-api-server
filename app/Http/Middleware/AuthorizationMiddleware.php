<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizationMiddleware
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
        if (!$request->header('app_key')) {
            return response()->json([
                'err_code' => 14,
                'err_desc' => 'unauthorized',
                'err_message' => 'you do not have authorization'
            ]);

        } else {
            if ($request->header('app_key') == env('APP_KEY')) {
                return $next($request);
            }
            return response()->json([
                'err_code' => 90,
                'err_desc' => 'invalid key',
                'err_message' => 'your app key is invalid'
            ]);
        }
    }
}
