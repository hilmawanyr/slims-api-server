<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;

class RowsPageMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->secure == false ? 'http://' : 'https://';
        $uri .= $request->getHttpHost() .'/'. $request->path();

        // URI valid if path is "articles" and without query string inside
        if ($request->fullUrl() == $uri) {
            return $next($request); 

        // do checking if URI contain query string
        } else {
            $getQueryString = array_keys($request->input());
            $numberOfQs = count($getQueryString);
            $mustContain = ['rows','page'];

            // if query string just have a key ...
            if ($numberOfQs == 1) {
                if (in_array($getQueryString[0], $mustContain)) {
                    return $next($request);
                }
                return response()->json([
                    'err_code' => '13',
                    'err_desc' => 'invalid uri',
                    'err_message' => 'URI you are submitted is invalid'
                ], 400);  

            // if query string that have two keys ...
            } else {
                $diff = array_diff($getQueryString, $mustContain);
                if (count($diff) == 0) {
                    return $next($request);
                }
                return response()->json([
                    'err_code' => '13',
                    'err_desc' => 'invalid uri',
                    'err_message' => 'URI you are submitted is invalid'
                ], 400);
            }
        }
    }

}