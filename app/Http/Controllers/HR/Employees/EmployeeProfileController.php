<?php

namespace hrmis\Http\Controllers\HR\Employees;

use hrmis\Models\Role;
use hrmis\Models\Group;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeStatus;
use hrmis\Http\Requests\EmployeeValidation;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeProfileController extends Controller
{
    public function index($id)
	{
		$employee 		= Employee::find($id);
		$emp_status 	= EmployeeStatus::get();
		$roles 			= Role::where('is_active', '=', 1)->get();
		$units 			= Group::where('is_active', '=', 1)->get();
		return view('hr.employees.profile.profile', compact('id', 'employee', 'emp_status', 'roles', 'units'));
	}

	public function reset($id)
	{
		$alert 					= 'alert-info';
		$message 				= 'Employee password successfully updated.';
		$employee 				= Employee::find($id);
		$employee->password 	= $employee->username;
		$employee->update();
		return redirect()->route('View Employee Profile', ['id' => $id])->with('message', $message)->with('alert', $alert);
	}

	public function submit(EmployeeValidation $request, $id)
	{
		$alert 		= 'alert-info';
		$message 	= 'Employee profile successfully updated.';
		$employee 	= Employee::find($id);
		$employee->touch();
		$employee->update($request->all());
		$employee->roles()->sync($request->get('role_id'));

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

		return redirect()->to($request->get('redirects_to'))->with('message', $message)->with('alert', $alert);
	}
}