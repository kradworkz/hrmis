<?php

namespace hrmis\Http\Controllers\HR\Employees;

use URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\Attendance;
use hrmis\Models\EmployeeCOC;
use hrmis\Models\OvertimeRequest;
use hrmis\Models\EmployeeSchedule;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
	public function index(Request $request, $id)
	{
		$print_dtr 	= true;
		$employee 	= Employee::find($id);
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');

		$years 		= config('app.years');
		$months 	= config('app.months');

		$weekdays 	= config('app.weekdays');
		$route 		= 'View Employee Attendance';

		$start 		= Carbon::createFromDate($year, $month, 1)->firstOfMonth();
		$end 		= Carbon::createFromDate($year, $month, 1)->lastOfMonth();

		$days 		= CarbonPeriod::create($start, $end);
		
		$attendance = Attendance::where('employee_id', '=', $id)->whereMonth('time_in', '=', $month)->whereYear('time_in', '=', $year)->orderBy('time_in', 'asc')->get();
		$details 	= Attendance::where('employee_id', '=', $id)->selectRaw('*, MIN(time_in) as t_in, MAX(time_out) as t_out, DATE_FORMAT(time_in, "%Y-%m-%d") as date')->whereMonth('time_in', '=', $month)->whereYear('time_in', '=', $year)->groupBy('date')->get();
		$schedule 	= EmployeeSchedule::where('employee_id', '=', $id)->get();
		$travels 	= Travel::tagged($id)->year($year)->month($month)->orderBy('start_date', 'desc')->get();
		$offset 	= Offset::where('employee_id', '=', $id)->year($year)->month($month)->orderBy('date', 'desc')->get();
		$coc 		= EmployeeCOC::where('employee_id', '=', $id)->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
		$latest_coc = EmployeeCOC::where('employee_id', '=', $id)->where('type', '=', 1)->latest()->first();
		$otr 		= OvertimeRequest::tagged($id)->year($year)->month($month)->orderBy('start_date', 'desc')->get();
		return view('hr.employees.dtr.dtr', compact('id', 'employee', 'attendance', 'details', 'year', 'years', 'month', 'months', 'schedule', 'weekdays', 'days', 'route', 'start', 'end', 'print_dtr', 'travels', 'offset', 'coc', 'latest_coc', 'otr'));
	}

	public function new($employee_id, $dtr_id = 0)
	{
		$attendance = new Attendance;
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name')->get();
		$employee 	= Employee::find($employee_id);
		return view('hr.employees.dtr.form', compact('dtr_id', 'employee_id', 'attendance', 'employee', 'employees'));
	}

	public function edit($employee_id, $dtr_id)
	{
		$attendance = Attendance::find($dtr_id);
		$employee 	= Employee::find($employee_id);
		$employees 	= Employee::where('employee_status_id', '=', 3)->where('is_active', '=', 1)->orderBy('last_name')->get();
		return view('hr.employees.dtr.form', compact('dtr_id', 'employee_id', 'attendance', 'employee', 'employees'));
	}

	public function delete($id)
	{
		$attendance = Attendance::find($id);
        $attendance->delete();
		$alert 	    = 'alert-success';
		$message    = 'Attendance successfully deleted.';
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		$time_in  = $request->get('time_in') != null ? ($request->get('date')." ".$request->get('time_in')).":".date('s') : null;
		$time_out = $request->get('time_out') != null ? ($request->get('date')." ".$request->get('time_out')).":".date('s') : null;

		if($id == 0) {
			$alert 						= 'alert-success';
			$message					= 'New attendance successfully added.';
			$attendance 				= new Attendance;
			$attendance->employee_id 	= $request->get('employee_id');
			$attendance->time_in 		= $time_in;
			$attendance->time_out 		= $time_out;
			$attendance->location 		= $request->get('location');
			$attendance->save();
		}
		else {
			$alert 						= 'alert-info';
			$message					= 'Attendance successfully updated.';
			$attendance 				= Attendance::find($id);
			$attendance->time_in 		= $time_in;
			$attendance->time_out 		= $time_out;
			$attendance->location 		= $request->get('location');
			$attendance->update();
		}
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}
}