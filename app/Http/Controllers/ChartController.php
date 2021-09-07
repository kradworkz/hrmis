<?php

namespace hrmis\Http\Controllers;

use Session;
use hrmis\Models\Offset;
use hrmis\Models\Travel;
use hrmis\Models\Leave;
use hrmis\Models\Group;
use hrmis\Models\LeaveDate;
use hrmis\Models\Attendance;
use hrmis\Models\TravelPassenger;
use hrmis\Http\Traits\CommentHelper;

class ChartController extends Controller
{
	public function get_unit_attendance($unit, $label, $date = null)
	{
		if($date == null) {
			$date == date('Y-m-d');
		}

		$attendance = array();
		$offset 	= array();
		$travels 	= array();
		$leave 		= array();


		$unit 		= Group::where('alias', '=', $unit)->first();
		if($label == 'Work from Home' || $label == 'Office') {
			$attendance = Attendance::whereDate('time_in', '=', $date)->where('location', '=', $label == 'Work from Home' ? 0 : 1)->whereHas('employee', function($employee) use($unit) {
				$employee->whereHas('unit', function($group) use($unit) {
					$group->where('id', '=', $unit->id);
				});
			})->get();
		}
		elseif($label == 'Offset') {
			$offset = Offset::whereDate('date', '=', $date)->whereHas('employee', function($employee) use($unit) {
				$employee->whereHas('unit', function($query) use($unit) {
					$query->where('id', '=', $unit->id);
				});
			})->get();
		}
		elseif($label == 'Travel') {
			$offset = TravelPassenger::whereHas('travels', function($query) use($date) {
				$query->active()->whereDate('start_date', '=', $date)->orWhereDate('end_date', '=', $date);
			})->whereHas('employee', function($employee) use($unit) {
				$employee->whereHas('unit', function($query) use($unit) {
					$query->where('id', '=', $unit->id);
				});
			})->get();
		}
		elseif($label == 'Leave') {
			$offset = LeaveDate::whereDate('date', '=', $date)->whereHas('leave', function($query) use($unit) {
				$query->whereHas('employee', function($employee) use($unit) {
					$employee->where('unit_id', '=', $unit->id);
				});
			})->get();
		}

		return view('dashboard.charts.unit', compact('unit', 'date', 'attendance', 'label', 'offset'));
	}
}