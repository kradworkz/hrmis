<?php

namespace hrmis\Http\Controllers\HR\Employees;

use URL;
use Carbon\Carbon;
use hrmis\Models\Attendance;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeDTRController extends Controller
{
	public function index(Request $request)
	{
		$date 		= $request->get('date');
		$dtr 		= Attendance::select('*', 'attendance.id as attendance_id')->whereDate('time_in', '=', Carbon::parse($date)->format('Y-m-d'))->join('employees', 'employees.id', '=', 'attendance.employee_id')->orderBy('last_name')->orderBy('time_in')->get();
		return view('dtr.dtr', compact('dtr', 'date'));
	}
}