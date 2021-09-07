<?php

namespace hrmis\Http\Controllers\HR\Employees;

use URL;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeSchedule;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeScheduleController extends Controller 
{
	public function index($id)
	{
		$employee 	= Employee::find($id);
		$route 		= 'View Employee Schedule';
		$schedule 	= EmployeeSchedule::where('employee_id', '=', $id)->get();
		return view('hr.employees.schedule.schedule', compact('id', 'schedule', 'employee'));
	}

	public function new($employee_id, $schedule_id = 0)
	{
		$schedule 	= new EmployeeSchedule;
		$employee 	= Employee::find($employee_id);
		$days       = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');
		return view('hr.employees.schedule.form', compact('schedule_id', 'schedule', 'employee', 'days'));
	}

	public function edit($employee_id, $schedule_id)
	{
		$employee 	= Employee::find($employee_id);
		$schedule 	= EmployeeSchedule::find($schedule_id);
		$days       = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');
		return view('hr.employees.schedule.form', compact('schedule_id', 'schedule', 'employee', 'days'));
	}

	public function delete($id)
	{
		$schedule 	= EmployeeSchedule::find($id);
        $schedule->delete();
		$alert 	    = 'alert-success';
		$message    = 'Employee schedule successfully deleted.';
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert              		= 'alert-success';
            $message            		= 'New employee schedule successfully updated.';
			$schedule 					= EmployeeSchedule::create($request->all());
		}
		else {
			$alert              		= 'alert-info';
            $message            		= 'Employee schedule successfully updated.';
			$schedule          			= EmployeeSchedule::find($id);
            $schedule->update($request->all());
		}

		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}
}