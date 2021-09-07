<?php

namespace hrmis\Http\Controllers\Settings;

use Auth;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeLogs;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
	public function index(Request $request)
	{
		$date 		= $request->get('date') == null ? date('Y-m-d') : $request->get('date');
		$route 		= 'Logs';
		$employee_id = $request->get('employee_id');
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$logs 		= EmployeeLogs::filter($employee_id, $date)->orderBy('created_at', 'asc')->get();
		return view('settings.logs.logs', compact('employees', 'employee_id', 'logs', 'route', 'date'));
	}
}