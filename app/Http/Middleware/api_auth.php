<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class api_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $backend_token = $request->header('backendToken');

        if( $backend_token != env('BACKEND_TOKEN')){
            return response()->json(['message' => 'Unauthorized', 'backendToken' => $backend_token], 401);
        }else{
            return $next($request);
        }
    }
}
