<?php

namespace hrmis\Http\Middleware;

use Auth;
use Closure;

class Signatory
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
        if(count(Auth::user()->signatories) || Auth::user()->is_superuser() || Auth::user()->is_health_officer() || Auth::user()->is_hr()) {
            return $next($request);
        }
        return redirect()->back()->with('message', 'You do not have the privilege to access this page.')->with('alert', 'alert-danger');
    }
}