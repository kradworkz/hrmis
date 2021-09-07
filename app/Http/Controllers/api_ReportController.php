<?php

namespace hrmis\Http\Controllers;

use Carbon\Carbon;
use hrmis\Models\Attendance;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\EmployeeHealthCheck;

class api_ReportController extends Controller
{
	public function report($year, $module)
	{
		$months 		= array_except(config('app.months'), ['00']);
		$labels 		= array_flatten($months);

		$approved 		= array();
		$disapproved 	= array();

		foreach(array_keys($months) as $month) {
			$approved[] 	= $this->get_data($year, $month, 1, $module);
			$disapproved[] 	= $this->get_data($year, $month, 2, $module);
		}

		$data = array(
			'labels' 		=> $labels,
			'approved' 		=> $approved,
			'disapproved' 	=> $disapproved,
		);

		return json_encode($data, true);
	}

	function get_data($year, $month, $action, $module)
	{
		$data = null;
		if($module == 'Travel Order') {
			$data = ApprovalStatus::where('action', '=', $action)->whereYear('created_at', '=', $year)->whereMonth('created_at', $month)->where('module_id', '=', 2)->whereHas('employee', function($employee) {
				$employee->whereHas('travel_signatory', function($signatory) {
					$signatory->where('signatory', '=', 'Approval');
				});
			})->count();
		}
		elseif($module == 'Offset') {
			$data = ApprovalStatus::where('action', '=', $action)->whereYear('created_at', '=', $year)->whereMonth('created_at', $month)->where('module_id', '=', 3)->whereHas('employee', function($employee) {
				$employee->whereHas('offset_signatory', function($signatory) {
					$signatory->where('signatory', '=', 'Approval');
				});
			})->count();
		}
		elseif($module == 'Leave') {
			$data = ApprovalStatus::where('action', '=', $action)->whereYear('created_at', '=', $year)->whereMonth('created_at', $month)->where('module_id', '=', 6)->whereHas('employee', function($employee) {
				$employee->whereHas('leave_signatory', function($signatory) {
					$signatory->where('signatory', '=', 'Approval');
				});
			})->count();
		}
		elseif($module == 'Overtime Request') {
			$data = ApprovalStatus::where('action', '=', $action)->whereYear('created_at', '=', $year)->whereMonth('created_at', $month)->where('module_id', '=', 4)->whereHas('employee', function($employee) {
				$employee->whereHas('overtime_signatory', function($signatory) {
					$signatory->where('signatory', '=', 'Approval');
				});
			})->count();
		}
		elseif($module == 'DTR Override') {
			if($action == 1) {
				$data = Attendance::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->where('updated_by', '!=', NULL)->where('status', '=', 1)->count();
			}
		}
		elseif($module == 'Vehicle Reservation') {
			$data = ApprovalStatus::where('action', '=', $action)->whereYear('created_at', '=', $year)->whereMonth('created_at', $month)->where('module_id', '=', 1)->whereHas('employee', function($employee) {
				$employee->whereHas('reservation_signatory', function($signatory) {
					$signatory->where('signatory', '=', 'Approval');
				});
			})->count();
		}
		elseif($module == 'Health Check') {
			if($action == 1) {
				$data = EmployeeHealthCheck::whereYear('date', '=', $year)->whereMonth('date', '=', $month)->where(function($query) {
					$query->where('temperature', '>', '38')
						->orWhere('fever', '!=', NULL)
						->orWhere('cough', '!=', NULL)
						->orWhere('ache', '!=', NULL)
						->orWhere('runny_nose', '!=', NULL)
						->orWhere('shortness_of_breath', '!=', NULL)
						->orWhere('diarrhea', '!=', NULL)
						->orWhere('q2', '!=', NULL)
						->orWhere('q4', '!=', NULL);
				})->distinct()->count('employee_id');
			}
		}

		return $data;
		
	}
}