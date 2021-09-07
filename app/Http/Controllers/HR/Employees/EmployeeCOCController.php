<?php

namespace hrmis\Http\Controllers\HR\Employees;

use URL;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeCOC;
use hrmis\Http\Controllers\HR\Employees\Controller;
use Illuminate\Http\Request;

class EmployeeCOCController extends Controller 
{
	public function index(Request $request, $id)
	{
		$employee   = Employee::find($id);
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');

		$years 		= config('app.years');
		$months 	= config('app.months');
		$route 		= 'View Employee COC';

		$coc 		= EmployeeCOC::where('employee_id', '=', $id)->year($year)->get();
		$latest_coc = EmployeeCOC::where('employee_id', '=', $id)->latest()->first();
		return view('hr.employees.coc.coc', compact('id', 'coc', 'employee', 'year', 'years', 'month', 'months', 'route', 'latest_coc'));
	}

	public function new($employee_id, $coc_id = 0)
	{
		$years 		= config('app.years');
		$months 	= config('app.months');
		$coc 		= new EmployeeCOC;
		$employee 	= Employee::find($employee_id);
		return view('hr.employees.coc.form', compact('coc_id', 'coc', 'employee', 'months', 'years'));
	}

	public function edit($employee_id, $coc_id)
	{
		$years 		= config('app.years');
		$months 	= config('app.months');
		$employee 	= Employee::find($employee_id);
		$coc 		= EmployeeCOC::find($coc_id);
		return view('hr.employees.coc.form', compact('coc_id', 'coc', 'employee', 'months', 'years'));
	}

	public function delete($id)
	{
		$coc 		= EmployeeCOC::find($id);
		if($coc->offset_id != null) {
			$offset = Offset::find($coc->offset_id);
			$offset->delete();
		}
        $coc->delete();
        $this->coc_update($coc->employee_id);
		$alert 	    = 'alert-success';
		$message    = 'Employee COC successfully deleted.';
		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $employee_id, $id)
	{
		$total_mins 	= ($request->get('beginning_hours')*60)+$request->get('beginning_minutes');
		$previous_coc 	= EmployeeCOC::where('employee_id', '=', $employee_id)->where('id', '<', $id)->orderBy('id', 'desc')->first();
		$remaining_coc 	= EmployeeCOC::where('employee_id', '=', $employee_id)->where('id', '>', $id)->orderBy('id', 'asc')->get();

		if($id == 0) {
			$latest_coc = EmployeeCOC::where('employee_id', '=', $employee_id)->latest()->first();
			if($latest_coc == null) {
				$request->request->add(['end_hours' 	=> $request->get('beginning_hours')]);
				$request->request->add(['end_minutes' 	=> $request->get('beginning_minutes')]);
				$request->request->add(['start' 		=> 1]);
				$request->request->add(['latest_balance'=> 1]);
			}

			$alert    = 'alert-success';
            $message  = 'New employee coc successfully added.';
			$coc  	  = EmployeeCOC::create($request->all());
		}
		else {
			$alert    		= 'alert-success';
        	$message  		= 'Employee coc successfully updated.';
			$coc 	   		= EmployeeCOC::find($id);
			
			if($coc->start != 0) {
				$request->request->add(['end_hours' 		=> $request->get('beginning_hours')]);
				$request->request->add(['end_minutes' 		=> $request->get('beginning_minutes')]);
				$request->request->add(['latest_balance' 	=> 1]);
			}

			$coc->update($request->all());
		}
		
		$this->coc_update($employee_id);

		return redirect(URL::previous())->with('message', $message)->with('alert', $alert);
	}

	function coc_update($employee_id)
	{
		$records 			= EmployeeCOC::where('employee_id', '=', $employee_id)->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
		$remaining_balance 	= 0;
		$length 			= count($records);
		foreach($records as $key => $record) {
			$current_coc = EmployeeCOC::find($record->id);
			if($remaining_balance) {
				$current_coc->update([
					'end_hours' 		=> $this->update_coc($record, $remaining_balance, 1),
					'end_minutes' 		=> $this->update_coc($record, $remaining_balance, 0),
					'latest_balance' 	=> $key == 0 ? 1 : ($key == $length-1 ? 1 : 0),
				]);
			}
			$remaining_balance = $current_coc;
		}
	}

	function update_coc($record, $remaining_balance, $mode)
	{
		$earned 	= ($record->beginning_hours*60)+$record->beginning_minutes;
		$offset 	= $record->offset_hours;
		$balance 	= ($remaining_balance->end_hours*60)+$remaining_balance->end_minutes;

		if($record->type == 1 && $record->offset_id == NULL) {
			$result = $balance+$earned;
		}
		elseif($record->type == 0 && $record->offset_id == NULL) {
			$result = $balance-$earned;
		}
		else {
			$result = $balance-($offset*60);
		}

		if($mode == 1) {
			return (int)($result/60);
		}
		else {
			return $result%60;
		}
	}

	function getMinutes($hours, $minutes)
	{
		return ($hours*60)+($minutes);
	}
}