<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtendSession
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
        // If user is a participant set re-sign in length to 28 days (28x24x60)
        if ($request->user() !== null && $request->user()->hasRole('participant')) {
            config(['session.lifetime' => 40320]);
        }

        return $next($request);
    }
}
