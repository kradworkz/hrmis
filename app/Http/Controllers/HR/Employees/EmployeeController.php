<?php

namespace hrmis\Http\Controllers\HR\Employees;

use Auth;
use hrmis\Models\Role;
use hrmis\Models\Group;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Module;
use hrmis\Models\Employee;
use hrmis\Models\Attendance;
use hrmis\Models\Reservation;
use hrmis\Models\EmployeeStatus;
use hrmis\Models\OvertimeRequest;
use hrmis\Http\Requests\EmployeeValidation;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
	public function index(Request $request)
	{
		$search 		= $request->get('search');
		$status 		= $request->get('employee_status_id');
		$unit 			= $request->get('group_id');

		$emp_status 	= EmployeeStatus::get();
		$groups 		= Group::orderBy('name', 'asc')->where('is_active', '=', 1)->get();
		$employees 		= Employee::where('is_active', '=', 1)->unit($unit)->status($status)->search($search)->orderBy('last_name', 'ASC')->get();
		return view('hr.employees.employees', compact('employees', 'search', 'emp_status', 'status', 'groups', 'unit'));
	}

	public function new()
	{
		$id 			= 0;
		$employee 		= new Employee;
		$emp_status 	= EmployeeStatus::get();
		$roles 			= Role::where('is_active', '=', 1)->get();
		$units 			= Group::where('is_active', '=', 1)->get();
		return view('hr.employees.form', compact('id', 'employee', 'emp_status', 'roles', 'units'));
	}

	public function submit(EmployeeValidation $request, $id)
	{
		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New employee successfully added.';
			$employee 	= Employee::create($request->all());
			$employee->roles()->attach($request->get('role_id'));
		}

		if($request->hasFile('picture')) {
            $request->file('picture')->storeAs('public/profile', $employee->username.".".$request->file('picture')->getClientOriginalExtension());
            $employee->picture  = $employee->username.".".$request->file('picture')->getClientOriginalExtension();
            $employee->save();
        }
        if($request->hasFile('signature')) {
            $filename = $employee->username.".".$request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->storeAs('employee_signature', $employee->username.".".$request->file('signature')->getClientOriginalExtension(), 'dost');
            $employee->signature = $filename;
            $employee->save();
        }

		return redirect()->route('Employees')->with('message', $message)->with('alert', $alert);
	}
}
