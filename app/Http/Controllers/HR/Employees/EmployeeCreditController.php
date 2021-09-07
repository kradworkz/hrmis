<?php

namespace hrmis\Http\Controllers\HR\Employees;

use URL;
use hrmis\Models\Leave;
use hrmis\Models\Employee;
use hrmis\Models\LeaveCredit;
use hrmis\Models\EmployeeBalance;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeCreditController extends Controller 
{
	public function index(Request $request, $id)
	{
		$employee   = Employee::find($id);
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');

		$years 		= config('app.years');
		$months 	= config('app.months');
		$route 		= 'Employee Leave Credit';

		$credits 	= LeaveCredit::where('employee_id', '=', $id)->get();
		return view('hr.employees.credits.credits', compact('id', 'employee', 'year', 'years', 'month', 'months', 'route', 'year', 'credits'));
	}

	public function new($employee_id, $credit_id = 0)
	{
		$years 		= config('app.years');
		$months 	= config('app.months');
		$credit 	= new LeaveCredit;
		$employee 	= Employee::find($employee_id);
		return view('hr.employees.credits.form', compact('credit_id', 'credit', 'employee', 'years', 'months'));
	}

	public function edit($employee_id, $credit_id)
	{
		$years 		= config('app.years');
		$months 	= config('app.months');
		$credit 	= LeaveCredit::find($credit_id);
		$employee 	= Employee::find($employee_id);
		return view('hr.employees.credits.form', compact('credit_id', 'credit', 'employee', 'years', 'months'));
	}

	public function delete($id)
	{
		$credit 	= LeaveCredit::find($id);
		if($credit->leave_id != null) {
			$leave = Leave::find($credit->leave_id);
			$leave->delete();
		}
        $credit->delete();
		$alert 	    = 'alert-success';
		$message    = 'Employee Leave Credit successfully deleted.';
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		$days 			= $request->get('days');
		$hours 			= $request->get('hours') > 0 ? config('app.hours')[$request->get('hours')] : 0;
		$minutes 		= $request->get('minutes') > 0 ? config('app.minutes')[$request->get('minutes')] : 0;;
		$latest_credit 	= LeaveCredit::where('employee_id', '=', $request->get('employee_id'))->first();
		$latest_bal 	= LeaveCredit::where('employee_id', '=', $request->get('employee_id'))->latest()->first();

		if($id == 0) {

			if(!$latest_credit) {
				$request->request->add(['vl_balance' => $request->get('vl_earned') - $request->get('vl_deduct')]);
				$request->request->add(['sl_balance' => $request->get('sl_earned') - $request->get('sl_deduct')]);
			}
			else {
				$total_particulars 	= $days+$hours+$minutes;
				$vl_balance 		= (($latest_bal->vl_balance + $request->get('vl_earned'))-$request->get('vl_deduct'))-$request->get('vl_deduct_without_pay');
				$sl_balance 		= (($latest_bal->sl_balance + $request->get('sl_earned'))-$request->get('sl_deduct'))-$request->get('vl_deduct_without_pay');

				if($request->get('particulars_for') == 'VL') {
					$vl_balance = $vl_balance-$total_particulars;
				}
				elseif($request->get('particulars_for') == 'SL') {
					$sl_balance	= $sl_balance-$total_particulars;
				}
				
				$request->request->add(['vl_balance' => $vl_balance]);
				$request->request->add(['sl_balance' => $sl_balance]);
			}

			$alert    	= 'alert-success';
        	$message  	= 'Employee leave credit successfully added.';
			$credit 	= LeaveCredit::create($request->except(['Submit']));
		}
		else {
			$alert    	= 'alert-success';
        	$message  	= 'Employee leave credit successfully updated.';
        	$credit 	= LeaveCredit::find($id);
        	$credit->update($request->except(['Submit']));
		}
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}
}