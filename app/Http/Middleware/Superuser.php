<?php

namespace hrmis\Http\Middleware;

use Auth, Closure;

class Superuser
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
        if(Auth::user()->is_superuser()) {
            return $next($request);
        }
        return redirect()->back()->with('message', 'You do not have the privilege to access this page.')->with('alert', 'alert-danger');
    }
}
