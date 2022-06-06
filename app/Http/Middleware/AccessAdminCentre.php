<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccessAdminCentre
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs("admin-centre.index") && Gate::allows('access-admin-centre')) return $next($request);
        if (preg_match("#^admin-centre\.users\..*$#", $request->route()->getName()) && Gate::allows('access-admin-centre.users')) return $next($request);

        return abort(403);
    }
}
