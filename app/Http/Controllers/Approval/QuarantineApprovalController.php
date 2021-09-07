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

class QuarantineApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route 			= 'Employee Quarantine Approval';
		if(Auth::user()->is_superuser() || Auth::user()->is_health_officer() || Auth::user()->is_hr()) {
			$status 	= $request->get('status') ?? 1;
		}
		else {
			$status 	= $request->get('status') ?? 0;
		}
		$signatory 	 	= Auth::user()->health_signatory != null ? Auth::user()->health_signatory->signatory : null;
		$signatories 	= SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 7)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->health_signatory != NULL) {
			$quarantine = EmployeeQuarantine::active()->where('employee_id', '!=', Auth::id())->whereIn('unit_id', $signatories)->signature($status, $signatory)->orderBy('created_at', 'desc')->get();
		}
		else {
			$quarantine = EmployeeQuarantine::where('status', '=', $status)->active()->get();
		}

		return view('approval.quarantine.quarantine', compact('route', 'status', 'quarantine'));
	}

	public function view($id)
	{
		$quarantine = EmployeeQuarantine::find($id);
		$approvals 	= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 7)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Health Check')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.quarantine.view', compact('id', 'quarantine', 'approvals'));
	}

	public function edit($id)
	{
		$quarantine = EmployeeQuarantine::find($id);
		$approvals 	= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 7)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Travel Order')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.quarantine.form', compact('id', 'quarantine', 'approvals'));
	}

	public function done($id)
	{
		$quarantine = EmployeeQuarantine::find($id);
		$quarantine->status = 0;
		$quarantine->save();

		return redirect()->route('Employee Quarantine Approval')->with('alert', 'alert-info')->with('message', 'Employee recommendation removed from list.');
	}

	public function submit(Request $request, $id)
	{
		$action 	= null;
		$alert 		= 'alert-info';
		$message 	= 'Employee quarantine approval successfully updated.';
		$quarantine = EmployeeQuarantine::find($id);

		if($request->has('unit_head')) {
			$action = $request->get('unit_head');
			if($quarantine->unit_head != $request->get('unit_head')) {
				$this->submitAction($id, 7, $request->get('unit_head'));
			}
		}

		if($request->has('recommending_to')) {
			$action = $request->get('recommending_to');
			if($quarantine->recommending_to != $request->get('recommending_to')) {
				$this->submitAction($id, 7, $request->get('recommending_to'));
			}
		}

		if($request->has('recommending_fas')) {
			$action = $request->get('recommending_fas');
			if($quarantine->recommending_fas != $request->get('recommending_fas')) {
				$this->submitAction($id, 7, $request->get('recommending_fas'));
			}
		}

		if($request->has('approval')) {
			$action = $request->get('approval');
			if($quarantine->approval != $request->get('approval')) {
				$this->submitAction($id, 7, $request->get('approval'));
			}
		}

		if(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Unit Head') {
			$request->request->add(['unit_head_by' 			=> Auth::id()]);
		}
		elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Recommending') {
			$request->request->add(['recommending_to_by' 	=> Auth::id()]);
		}
		elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Recommending FAS') {
			$request->request->add(['recommending_fas_by' 	=> Auth::id()]);
		}
		elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Approval') {
			$request->request->add(['approval_by' 			=> Auth::id()]);
		}

		$quarantine->update($request->all());

		// if(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Approval' && $quarantine->approval == 1) {
		// 	$this->newNotification(array($quarantine->employee->id), $quarantine->id, 'Health Check', 'View Employee Quarantine', 'Approved');
		// }

		$this->submitComment($id == 0 ? $quarantine->id : $id, 7);
		return redirect()->route('Employee Quarantine Approval')->with('message', $message)->with('alert', $alert);
	}
}