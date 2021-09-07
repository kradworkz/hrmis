<?php

namespace hrmis\Http\Middleware;

use Auth;
use Closure;

class Administrator
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
        if(Auth::user()->is_superuser() || Auth::user()->is_administrator() || Auth::user()->is_health_officer() || Auth::user()->is_hr() || Auth::user()->is_head() || Auth::user()->is_assistant()) {
            return $next($request);
        }
        return redirect()->back()->with('message', 'You do not have the privilege to access this page.')->with('alert', 'alert-danger');
    }
}
