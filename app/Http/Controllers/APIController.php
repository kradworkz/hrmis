<?php

namespace hrmis\Http\Controllers;

use Carbon\Carbon;
use hrmis\Models\Group;
use hrmis\Models\Offset;
use hrmis\Models\Travel;
use hrmis\Models\TravelPassenger;
use hrmis\Models\Leave;
use hrmis\Models\LeaveDate;
use hrmis\Models\Employee;
use hrmis\Models\Attendance;
use hrmis\Models\EmployeeCOC;
use hrmis\Models\OvertimeCredit;

class APIController extends Controller
{
	public function coc()
	{
		$employees = Employee::where('is_active', '=', 1)->get();
		foreach($employees as $employee) {
			$this->coc_update($employee->id);
		}
	}

	function coc_update($employee_id)
	{
		$records 			= EmployeeCOC::where('employee_id', '=', $employee_id)->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
		$remaining_balance 	= 0;
		$length 			= count($records);
		foreach($records as $key => $record) {
			$current_coc = EmployeeCOC::find($record->id);
			if($current_coc->start == 1) {
				$current_coc->update(['latest_balance' => 1]);
			}
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

		if($record->type == 1) {
			$result = $balance+$earned;
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

	public function attendance_chart($date)
	{
		$offset = array();
		$travels = array();
		$leave = array();
		$units = $this->getUnits();

		// foreach($this->getAttendanceData($date)->pluck('id') as $id) {
		// 	$offset[] 	= $this->offset_query($date, $id);
		// 	$travels[] 	= $this->travel_query($date, $id);
		// 	$leave[] 	= $this->leave_query($date, $id);
		// }

		// $data = array(
		// 	'labels' 	=> $this->getAttendanceData($date)->pluck('alias'),
		// 	'wfh' 	 	=> $this->getAttendanceData($date)->pluck('wfh'),
		// 	'office' 	=> $this->getAttendanceData($date)->pluck('office'),
		// 	'offset' 	=> $offset,
		// 	'travels' 	=> $travels,
		// 	'leave' 	=> $leave
		// );

		foreach($units as $unit) {
			$offset[] 	= $this->offset_query($date, $unit->id);
			$travels[] 	= $this->travel_query($date, $unit->id);
			$leave[] 	= $this->leave_query($date, $unit->id);
		}

		$data = array(
			'labels' => $units->pluck('alias')->toArray(),
			'wfh' => $this->getAttendanceData($date, 0),
			'office' => $this->getAttendanceData($date, 1),
			'offset' 	=> $offset,
			'travels' 	=> $travels,
			'leave' 	=> $leave
		);

		return json_encode($data, true);
	}

	public function getAttendanceData($date, $location)
	{
		$attendance = array();
		$units = $this->getUnits();
		foreach($units as $unit) {
			$attendance[] = Attendance::where('location', '=', $location)->whereDate('time_in', '=', $date)->whereHas('employee', function($employee) use($unit) {
				$employee->whereHas('unit', function($query) use($unit) {
					$query->where('id', '=', $unit->id);
				});
			})->count();
		}

		return $attendance;
	}

	public function getUnits()
	{
		$units = Group::where('is_active', '=', 1)->where('whereabouts', '=', 1)->orderBy('name')->get();
		return $units;
	}

	// public function getAttendanceData($date)
	// {
	// 	$attendance = Attendance::selectRaw('groups.id, groups.alias, count(*) as total, SUM(attendance.location = 1) as office, SUM(attendance.location = 0) as wfh')
	// 					->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
	// 					->leftJoin('groups', 'groups.id', '=', 'employees.unit_id')
	// 					->whereDate('time_in', '=', $date)
	// 					->groupBy('unit_id')
	// 					->orderBy('total', 'desc')
	// 					->get();

	// 	return $attendance;
	// }

	function offset_query($date, $unit_id)
	{
		$offset = Offset::active()->whereDate('date', '=', $date)->whereHas('employee', function($query) use($unit_id) {
			$query->whereHas('unit', function($unit) use($unit_id) {
				$unit->where('id', '=', $unit_id);
			});
		})->count();

		return $offset;
	}

	function travel_query($date, $unit_id)
	{
		$travels = TravelPassenger::whereHas('travels', function($query) use($date) {
			$query->active()->whereDate('start_date', '=', $date)->orWhereDate('end_date', '=', $date);
		})->whereHas('employee', function($employee) use($unit_id) {
			$employee->whereHas('unit', function($unit) use($unit_id) {
				$unit->where('id', '=', $unit_id);
			});
		})->count();

		return $travels;
	}

	function leave_query($date, $unit_id)
	{
		$leave = LeaveDate::whereDate('date', '=', $date)->whereHas('leave', function($query) use($unit_id) {
			$query->whereHas('employee', function($employee) use($unit_id) {
				$employee->where('unit_id', '=', $unit_id);
			});
		})->count();

		return $leave;
	}
}