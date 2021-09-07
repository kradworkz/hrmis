<?php

namespace hrmis\Http\Controllers\HR;

use URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\EmployeeCOC;
use hrmis\Models\EmployeeStatus;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompensatoryOvertimeController extends Controller
{
	public function index(Request $request)
	{
		$year 					= $request->get('year') ?? date('Y');
		$month 					= $request->get('month') ?? date('m');
		$employment_status_id 	= $request->get('employment_status_id');
		$years 					= config('app.years');
		$months 				= config('app.months');
		$coc 					= EmployeeCOC::status($employment_status_id)->where('beginning_hours', '!=', NULL)->where('offset_id', '=', NULL)->where('year', '=', $year)->where('month', '=', $month)->orderBy('created_at', 'desc')->get();
		$status 				= EmployeeStatus::get();
		return view('hr.coc.coc', compact('coc', 'year', 'month', 'years', 'months', 'employment_status_id', 'status'));
	}
}