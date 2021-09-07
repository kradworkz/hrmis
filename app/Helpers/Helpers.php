<?php 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Leave;
use hrmis\Models\Offset;
use hrmis\Models\Travel;
use hrmis\Models\LeaveDate;
use hrmis\Models\Attendance;
use hrmis\Models\OvertimeCredit;
use hrmis\Models\CalendarEvent;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\EmployeeSchedule;

function getDateDiff($date)
{
	$date = Carbon::parse($date);
	$seconds = $date->diffInSeconds(Carbon::now());
	$minutes = $date->diffInMinutes(Carbon::now());
	$days = $date->diffInDays(Carbon::now());

	if($minutes == 0) {
		echo Carbon::now()->subSeconds($seconds)->diffForHumans();
	}
	elseif($days == 0) {
		echo Carbon::now()->subMinutes($minutes)->diffForHumans();
	}
	else {
		echo Carbon::now()->subDays($days)->diffForHumans();
	}
}

function getMonthName($monthNumber)
{
	return date("F", mktime(0, 0, 0, $monthNumber, 1));
}

function getEmployeeAttendance($id, $date, $mode, $dtr = 0)
{
	if(date('Y-m-d') >= $date->format('Y-m-d')) {
		if($mode == 0) { /* First Time In */
	 		$attendance = Attendance::where('employee_id', '=', $id)->whereDate('time_in', '=', $date->format('Y-m-d'))->first();
	 		if($attendance == null) {
	 			if($date->format('l') != 'Saturday' && $date->format('l') != 'Sunday') {
	 				if(getHoliday($date) == null) {
	 					if(getEmployeeTravel($id, $date) == null && getEmployeeOffset($id, $date) == null && $dtr == 0) {
	 						return "<i class='text-danger font-weight-bold'>ABSENT</i>";
	 					}
	 				}
	 			}
	 		}
	 		else {
	 			if($attendance->location == 0) {
	 				return "<span class='text-primary'>".$attendance->time_in->format('h:i A')."</span>";
	 			}
	 			else {
	 				return $attendance->time_in->format('h:i A');
	 			}
	 		}
		}
		elseif($mode == 1) { /* Second Time Out */
			$attendance = Attendance::where('employee_id', '=', $id)->whereDate('time_in', '=', $date->format('Y-m-d'))->latest()->first();
			if($attendance && $attendance->time_out != null) {
				if($attendance->location == 0) {
					return "<span class='text-primary'>".$attendance->time_out->format('h:i A')."</span>";
				}
				else {
					return $attendance->time_out->format('h:i A');
				}
			}
	 		// return $attendance != null ? ($attendance->time_out != null ? $attendance->time_out->format('h:i A') : '') : '';
		}
		elseif($mode == 2) { /* Second Time In */
			$attendance = Attendance::where('employee_id', '=', $id)->whereDate('time_in', '=', $date->format('Y-m-d'))->get();
			if(count($attendance) >= 2) {
				if($attendance[1]->location == 0) {
					return "<span class='text-primary'>".$attendance[1]->time_in->format('h:i A')."</span>";
				}
				else {
					return $attendance[1]->time_in->format('h:i A');
				}
			}
		}
		elseif($mode == 3) { /* First Time Out */
			$attendance = Attendance::where('employee_id', '=', $id)->whereDate('time_in', '=', $date->format('Y-m-d'))->get();
			if(count($attendance) >= 2) {
				if($attendance[0]->location == 0) {
					return "<span class='text-primary'>".optional($attendance[0]->time_out)->format('h:i A')."</span>";
				}
				else {
					return optional($attendance[0]->time_out)->format('h:i A');
				}
			}
		}
	}
}

function getEmployeeTravel($id, $date, $mode = null)
{
	$travels = Travel::where('is_active', '=', 1)->whereYear('start_date', '=', $date->format('Y'))->whereMonth('start_date', '=', $date->format('m'))->where(function($query) use($id) {
                $query->whereHas('travel_passengers', function($passengers) use($id) {
                    $passengers->where('travel_passengers.employee_id', '=', $id);
                });
            })->get();

	foreach($travels as $travel) {
		$travel_dates = CarbonPeriod::create($travel->start_date, $travel->end_date);
		foreach($travel_dates as $tdate) {
			if($tdate->format('Y-m-d') == $date->format('Y-m-d')) {
				if($mode == 1) {
					return $travel->time_mode;
				}
				elseif($mode == 2) {
					return "<a href='#' class='text-decoration-none' data-toggle='tooltip' data-title='".$travel->destination."'>Official Business</a>";
				}
				else {
					return "<a href='#' class='text-decoration-none' data-toggle='tooltip' data-title='".$travel->destination."'>".$travel->time_mode."</a>";
				}
			}
		}
	}
}

function getEmployeeOffset($id, $date, $mode = 0)
{
	$offset = Offset::where('is_active', '=', 1)->whereDate('date', '=', $date)->where('employee_id', '=', $id)->first();
	if($offset != null) {
		if($mode == 1) {
			return "<a href='#' class='text-danger text-decoration-none' data-toggle='tooltip' data-title='".$offset->time."'>Offset</a>";
		}
		else {
			if($offset->time == '8:00 to 5:00') {
				return "Whole Day";
			}
			elseif($offset->time == '8:00 to 12:00') {
				return "AM";
			}
			elseif($offset->time == '1:00 to 5:00') {
				return "PM";
			}
		}

	}
}

function getEmployeeLeave($id, $date, $mode)
{
	$leave = LeaveDate::whereHas('leave', function($query) use($id) {
		$query->where('employee_id', '=', $id);
	})->whereDate('date', '=', $date)->where('approval', '=', 1)->first();

	if($leave) {
		return "<a href='#' class='text-danger text-decoration-none'>{$leave->leave->type}</a>";
	}
}

function getHoliday($date) 
{
	$holiday = CalendarEvent::whereDate('date', '=', $date)->where('is_active', '=', 1)->first();
	return $holiday != null ? $holiday->title : '';
}

function getEmployeeSchedule($id, $date, $mode = 0)
{
	$schedule = EmployeeSchedule::where('employee_id', '=', $id)->where('day', '=', $date->format('N'))->first();
	if($mode == 0) {
		$time_in  	= new Carbon($date->format('Y-m-d')." ".($schedule != null ? $schedule->time_in : '08:00'));
		return $time_in;
	}
	elseif($mode == 1) {
		$time_out  = new Carbon($date->format('Y-m-d')." ".($schedule != null ? $schedule->time_out : '17:00'));
		return $time_out;
	}
}

function getEmployeeLate($id, $date)
{
	$atdc 		= Attendance::where('employee_id', '=', $id)->selectRaw('*, MIN(time_in) as time_in, MAX(time_out) as time_out')->whereDate('time_in', '=', $date)->first();
	$time_in 	= $atdc->time_in;
	$lunch 		= new Carbon($date->format('Y-m-d').' 12:00');
	$pm 		= new Carbon($date->format('Y-m-d').' 13:00');
	$am 		= $date->dayOfWeek == 1 ? getEmployeeSchedule($id, $date) : getEmployeeSchedule($id, $date)->addMinutes(15);

	if(getEmployeeAttendance($id, $date, 0) != null && getEmployeeAttendance($id, $date, 1) != null) { /* Time in and Time Out exists */
		if($date->englishDayOfWeek != 'Saturday' && $date->englishDayOfWeek != 'Sunday' && !getHoliday($date)) { /* Exclude Weekends and Holidays */

			if(getEmployeeOffset($id, $date) == 'AM') {
				$time_in = new Carbon($date->format('Y-m-d').' 13:00');
			}

			if($time_in->greaterThan($am) && $time_in->lessThan($lunch)) {
				return $time_in->diffInMinutes($am). ' minute(s)';
			}
			elseif($time_in->greaterThan($pm)) {
				return $time_in->diffInMinutes($pm). ' minute(s)';
			}
		}
	}
}

function getEmployeeLateSummary($id, $year, $month)
{
	$attendance = Attendance::where('employee_id', '=', $id)->whereYear('time_in', '=', $year)->whereMonth('time_in', '=', $month)->whereRaw('DATE_FORMAT(time_in, "%h:%i") > "08:15" AND DATE_FORMAT(time_in, "%h:%i") < "10:59"')->count();
	return $attendance == 0 ? '' : $attendance;
}

function getEmployeeEarned($id, $date, $mode = 0)
{
	$atdc 	= Attendance::where('employee_id', '=', $id)->selectRaw('*, MIN(time_in) as time_in, MAX(time_out) as time_out')->whereDate('time_in', '=', $date)->first();
	$lunch 	= new Carbon($date->format('Y-m-d').' 12:00');
	$pm 	= new Carbon($date->format('Y-m-d').' 13:00');
	$am 	= getEmployeeSchedule($id, $date);
	$out  	= getEmployeeSchedule($id, $date, 1);
	$result = null;
	if(getEmployeeAttendance($id, $date, 0) != null && getEmployeeAttendance($id, $date, 1) != null) { /* Time in and Time Out exists */
		$employee_hours = $atdc->time_in->diffInMinutes($lunch)+$pm->diffInMinutes($atdc->time_out);
		if(!getHoliday($date) && ($date->englishDayOfWeek != 'Saturday' || $date->englishDayOfWeek != 'Sunday')) { /* Regular Working Days */
			if($employee_hours >= 480) {
				$grace_period = $atdc->time_in->diffInMinutes($am);
				if($atdc->time_in->greaterThan($am)) {
					if($grace_period <= 15) {
						$flexi_out = $out->addMinutes($grace_period);
						if($atdc->time_out->diffInMinutes($flexi_out) >= 10) {
							$result = $atdc->time_out->diffInMinutes($flexi_out)." minute(s)";
						}
					}
					else {
						if($atdc->time_out->diffInMinutes($out) >= 10) {
							$result = $atdc->time_out->diffInMinutes($out)." minute(s)";
						}
					}
				}
				else {
					if($atdc->time_in->lessThan($am)) {
						if($atdc->time_in->diffInMinutes($am) >= 10) {
							$result = $atdc->time_in->diffInMinutes($am)." minute(s)";
						}
					}
					if($atdc->time_out->greaterThan($out)) {
						if($atdc->time_out->diffInMinutes($out) >= 10) {
							$result = $atdc->time_out->diffInMinutes($out)." minute(s)";
						}
					}
				}
			}
		}
		else { /* Holiday, thus hours * 1.5 */
			$result = (int)($employee_hours*1.5)." minute(s)";
		}
		if($mode == 1) {
			$result = preg_replace('/\D/', '', $result);
		} 
		return $result;
	}
}

function getEmployeeSignatory($unit_id, $module_id)
{
	$signatories 		= SignatoryGroup::where('group_id', '=', $unit_id)->whereHas('signatory', function($query) use($module_id) {
		$query->where('module_id', '=', $module_id);
	})->get();

	$employees 	 		= collect([]);
	foreach($signatories as $sg) {
		$employees[] 	= $sg->signatory->employee;
	}
	return $employees;
}

function getEmployeeCOC($id)
{
	$hours 		= OvertimeCredit::where('employee_id', '=', $id)->where('type', '=', 0)->where('is_active', '=', 1)->sum('hours');
	$lapse_hour = OvertimeCredit::where('employee_id', '=', $id)->where('type', '=', 1)->where('is_active', '=', 1)->sum('hours');
	$minutes 	= OvertimeCredit::where('employee_id', '=', $id)->where('type', '=', 0)->where('is_active', '=', 1)->sum('minutes');
	$lapse_min 	= OvertimeCredit::where('employee_id', '=', $id)->where('type', '=', 1)->where('is_active', '=', 1)->sum('minutes');
	$used_coc 	= Offset::where('employee_id', '=', $id)->where('is_active', '=', 1)->where(function($query) {
					$query->where('recommending', '!=', 2)->orWhere('approval', '!=', 2);
				})->sum('hours');
	$total_coc 	= $hours+floor(($minutes-$lapse_min)/60)-$lapse_hour-$used_coc."h ".convertToMins($minutes-$lapse_min, '%02dm');
	$coc 		= array(
					'readable_coc' 	=> $total_coc,
					'coc_hours' 	=> $hours+floor(($minutes-$lapse_min)/60)-$lapse_hour-$used_coc,
					'coc_minutes' 	=> convertToMins($minutes-$lapse_min, '%02d'),
				);
	return $coc;
}

function convertToMins($time, $format = '%02d') 
{
	if($time < 1) {
		return;
	}
	$hours 		= floor($time/60);
	$minutes 	= ($time % 60);
	return sprintf($format, $minutes);
}

function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function getStatus($module)
{
	$recommending 	= '';
	$approval 		= '';
	if($module->recommending == 1) {
		$recommending = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Approved"></i>';
	}
	elseif($module->recommending == 2) {
		$recommending = '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Disapproved"></i>';
	}

	if($module->approval == 1) {
		$approval = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Approved"></i>';
	}
	elseif($module->approval == 2) {
		$approval = '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Disapproved"></i>';
	}

	return $recommending." ".$approval;
}

function formatMonth($month)
{
	$month = date("F", mktime(0, 0, 0, $month));
	return $month;
}

function getDays($start, $end)
{
	if($start != $end) {
		$days = CarbonPeriod::create($start, $end);
		foreach($days as $day) {
			$data[] = $day->format('Y-m-d');
		}
	}
	else {
		$data[] = $start->format('Y-m-d');
	}
	return $data;
}

function getDifference($start, $end)
{
	$start 	= strtotime($start);
	$end 	= strtotime($end);
    return round(abs($start - $end) / 60,2);
}

function getIp()
{
	foreach(array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if(array_key_exists($key, $_SERVER) === true) {
            foreach(explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}