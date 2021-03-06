<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JwtTokenMiddleware
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
        /** PUTTING THE JWT TOKEN IN THE HEADER */
        $token = \Cookie::get('jwt_token');
        $request->headers->set("Authorization", $token);
        $response = $next($request);


        return $response;
    }
}
