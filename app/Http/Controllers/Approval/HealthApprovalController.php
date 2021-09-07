<?php

namespace hrmis\Http\Controllers\Approval;

use Auth, Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Employee;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\EmployeeQuarantine;
use hrmis\Models\EmployeeHealthCheck;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthApprovalController extends Controller
{
	public function index(Request $request)
	{
		$route 	= 'Health Check Approval';
		$date 	= $request->get('date') == null ? date('Y-m-d') : $request->get('date');
		$risks 	= EmployeeHealthCheck::where(function($query) {
			$query->where('temperature', '>', '38')
				->orWhere('fever', '!=', NULL)
				->orWhere('cough', '!=', NULL)
				->orWhere('ache', '!=', NULL)
				->orWhere('runny_nose', '!=', NULL)
				->orWhere('shortness_of_breath', '!=', NULL)
				->orWhere('diarrhea', '!=', NULL)
				->orWhere('sore_throat', '!=', NULL)
				->orWhere('loss_of_taste', '!=', NULL)
				->orWhere('q2', '!=', NULL)
				->orWhere('q4', '!=', NULL);
	})->date($date)->where('verified', '=', 0)->orderBy('date', 'desc')->get();

		return view('approval.health.health', compact('risks', 'route', 'date'));
	}

	public function edit($id)
	{
		$employee = EmployeeHealthCheck::find($id);
		return view('approval.health.form', compact('id', 'employee'));
	}

	public function view($id)
	{
		$employee = EmployeeHealthCheck::find($id);
		return view('approval.health.form', compact('id', 'employee'));
	}

	public function submit(Request $request, $id)
	{
		$alert 		= 'alert-info';
		$message 	= 'Employee health recommendation successfully submitted.';

		
		if(!$request->has('medical_certificate')) {
			$request->request->add(['medical_certificate' => 0]);
		}

		if($id != 0) {
			$employee = EmployeeHealthCheck::find($id);
			$employee->verified = 1;
			$employee->verified_by = Auth::id();
			$employee->save();

			if($employee) {
				$request->request->add(['employee_health_check_id' 	=> $employee->id]);
				$request->request->add(['employee_id' 				=> $employee->employee_id]);
				$request->request->add(['unit_id' 					=> $employee->employee->unit_id]);
				$request->request->add(['endorsed_by' 				=> Auth::id()]);

				$quarantine = EmployeeQuarantine::create($request->all());
			}
		}

		return redirect()->route('Health Check Approval')->with('message', $message)->with('alert', $alert);
	}
}
