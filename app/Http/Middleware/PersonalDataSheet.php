<?php

namespace hrmis\Http\Middleware;

use Auth;
use Closure;

class PersonalDataSheet
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
        if(Auth::user()->is_hr() || Auth::user()->is_superuser() || Auth::id() == $request->segment(4) || Auth::id() == $request->segment(5) ||Auth::id() == $request->employee_id) {
            return $next($request);
        }

        return redirect()->back()->with('message', 'You do not have the privilege to access this page.')->with('alert', 'alert-danger');
    }
}