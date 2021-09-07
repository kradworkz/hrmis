<?php

namespace hrmis\Http\Controllers\HR;

use URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravelController extends Controller
{
	public function index(Request $request)
	{
		$employee_id 	= $request->get('employee_id');
		$search  		= $request->get('search') == null ? '' : $request->get('search');
		$employees 		= Employee::where('is_active', '=', 1)->orderBy('last_name')->get();
		$travels 		= Travel::active()->employee($employee_id)->search($search)->orderBy('start_date', 'desc')->paginate(100);
		return view('hr.travels.travels', compact('travels', 'employees', 'employee_id'));
	}
}