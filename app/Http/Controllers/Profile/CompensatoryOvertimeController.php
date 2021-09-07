<?php

namespace hrmis\Http\Controllers\Profile;

use URL, Auth;
use hrmis\Models\Offset;
use hrmis\Models\EmployeeCOC;
use hrmis\Http\Controllers\Profile\Controller;
use Illuminate\Http\Request;

class CompensatoryOvertimeController extends Controller 
{
	public function index(Request $request)
	{
		$year 			  = $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			  = $request->get('month') == null ? date('m') : $request->get('month');
		$search 		  = $request->get('search') == null ? '' : $request->get('search');

		$years 			  = config('app.years');
		$months 		  = config('app.months');
		$route 			  = 'Compensatory Overtime Credit';

		$coc 			  = EmployeeCOC::where('employee_id', '=', Auth::id())->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
		return view('profile.coc.coc', compact('coc', 'year', 'years', 'route', 'month', 'months'));
	}
}