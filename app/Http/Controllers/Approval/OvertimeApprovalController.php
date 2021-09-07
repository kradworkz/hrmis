<?php

namespace hrmis\Http\Controllers\Approval;

use Auth;
use hrmis\Models\Notification;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\OvertimeRequest;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OvertimeApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route 		 	= 'Overtime Approval';
		$status 	 	= $request->get('status') ?? 0;
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$signatory 	 	= Auth::user()->overtime_signatory != null ? Auth::user()->overtime_signatory->signatory : null;
		$signatories 	= SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 4)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->offset_signatory != null) {
			$overtime  	= OvertimeRequest::where('employee_id', '!=', Auth::id())->signatory($signatories, $signatory)->employees($search)->signature($status, $signatory)->active()->orderBy('created_at', 'desc')->paginate(20);
		}
		elseif(Auth::user()->is_superuser() || Auth::user()->is_hr()) {
			$overtime  	= OvertimeRequest::employees($search)->orderBy('created_at', 'desc')->paginate(20);
		}

		return view('approval.overtime.overtime', compact('route', 'search', 'status', 'overtime'));
	}

	public function edit($id)
	{
		$overtime 		= OvertimeRequest::find($id);
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 4)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Overtime Request')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.overtime.form', compact('id', 'overtime', 'approvals'));
	}

	public function view($id)
	{
		$overtime 		= OvertimeRequest::find($id);
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 4)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Overtime Request')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.overtime.view', compact('id', 'overtime', 'approvals'));
	}

	public function submit(Request $request, $id)
	{
		$action 		= null;
		$overtime  		= OvertimeRequest::find($id);
		if($request->has('recommending')) {
			$action 	= $request->get('recommending');
			if($overtime->recommending != $request->get('recommending')) {
				$this->submitAction($id, 4, $request->get('recommending'));
			}
		}
		if($request->has('approval')) {
			$action 	= $request->get('approval');
			if($overtime->approval != $request->get('approval')) {
				$this->submitAction($id, 4, $request->get('approval'));
			}
		}

		if(Auth::user()->overtime_signatory->signatory == 'Recommending') {
			$request->request->add(['recommending_by'           => Auth::id()]);
            $request->request->add(['recommending_notification' => 0]);
		}
		elseif(Auth::user()->overtime_signatory->signatory == 'Approval') {
			$request->request->add(['approval_by'               => Auth::id()]);
            $request->request->add(['approval_notification'     => 0]);
		}
		else {
			$request->request->add(['checked_by'                => Auth::id()]);
		}

		$alert 		= 'alert-info';
		$message 	= 'Overtime Request successfully updated.';
		$overtime->update($request->all());

		if($action == 1 || $action == 2) {
			$this->newNotification(array($overtime->employee->id), $overtime->id, 'Overtime Request', 'View Overtime Request', $action == 1 ? 'Approved' : 'Disapproved');
		}

		$this->submitComment($id == 0 ? $overtime->id : $id, 4);
		return redirect()->route('Overtime Approval')->with('message', $message)->with('alert', $alert);
	}
}