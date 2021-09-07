<?php

namespace hrmis\Http\Controllers\Approval;

use Auth;
use hrmis\Models\Leave;
use hrmis\Models\LeaveDate;
use hrmis\Models\Notification;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route  	 = 'Leave Approval';
		$status 	 = $request->get('status') ?? 0;
		$search 	 = $request->get('search') == null ? '' : $request->get('search');
		$signatory 	 = Auth::user()->leave_signatory != null ? Auth::user()->leave_signatory->signatory : null;
		$signatories = SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 6)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->leave_signatory != null) {
			$leave = Leave::where('employee_id', '!=', Auth::id())->signatory($signatories, $signatory)->employees($search)->signature($status, $signatory)->active()->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_superuser()) {
			$leave 	= Leave::active()->orderBy('created_at', 'desc')->paginate(50);
		}
		
		return view('approval.leave.leave', compact('route', 'leave', 'status', 'search'));
	}

	public function edit($id)
	{
		$leave 				= Leave::find($id);
		$approvals 			= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 6)->get();
		$disapproved_dates 	= LeaveDate::where('leave_id', '=', $id)->where(function($query) {
								$query->where('chief_approval', '=', 2)->orWhere('recommending', '=', 2)->orWhere('approval', '=', 2);
							})->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Leave')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.leave.form', compact('id', 'leave', 'approvals', 'disapproved_dates'));
	}

	public function view($id)
	{
		$leave 				= Leave::find($id);
		$approvals 			= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 6)->get();
		$disapproved_dates 	= LeaveDate::where('leave_id', '=', $id)->where(function($query) {
								$query->where('chief_approval', '=', 2)->orWhere('recommending', '=', 2)->orWhere('approval', '=', 2);
							})->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Leave')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.leave.view', compact('id', 'leave', 'approvals', 'disapproved_dates'));
	}

	public function submit(Request $request, $id)
	{
		$action = null;
		$leave  = Leave::find($id);

		if($request->has('recommending')) {
			$action = $request->get('recommending');
			if($leave->recommending != $request->get('recommending')) {
				$this->submitAction($id, 6, $request->get('recommending'));
			}

			$this->disapproved_dates($request->get('dates'), 'recommending', 'recommending_by', $id);
		}

		if($request->has('approval')) {
			$action = $request->get('approval');
			if($leave->approval != $request->get('approval')) {
				$this->submitAction($id, 6, $request->get('approval'));
			}

			$this->disapproved_dates($request->get('dates'), 'approval', 'approval_by', $id);
		}

		if(Auth::user()->leave_signatory->signatory == 'Recommending') {
			$request->request->add(['recommending_by'           => Auth::id()]);
            $request->request->add(['recommending_notification' => 0]);
		}
		elseif(Auth::user()->leave_signatory->signatory == 'Approval') {
			$request->request->add(['approval_by'               => Auth::id()]);
            $request->request->add(['approval_notification'     => 0]);
		}

		$alert 		= 'alert-info';
		$message 	= 'Leave successfully updated.';

		$dates 				= count($leave->leave_dates);
		$disapproved_dates 	= LeaveDate::where('leave_id', '=', $leave->id)->where('recommending', '=', 2)->orWhere('approval', '=', 2)->count();

		if($leave->type == 'Sick Leave') {
			$request->request->add(['approved_sick_leave' 		=> $dates-$disapproved_dates]);
			$request->request->add(['approved_vacation_leave' 	=> 0]);
		}
		else {
			$request->request->add(['approved_vacation_leave' 	=> $dates-$disapproved_dates]);
			$request->request->add(['approved_sick_leave' 		=> 0]);
		}
		
		$leave->update($request->except(['comment', 'Submit', 'date', 'dates']));
		
		if($action == 1 || $action == 2) {
			$this->newNotification(array($leave->employee->id), $leave->id, 'Leave', 'View Leave', $action == 1 ? 'Approved' : 'Disapproved');
		}

		$this->submitComment($id == 0 ? $leave->id : $id, 6);
		return redirect()->route('Leave Approval')->with('message', $message)->with('alert', $alert);
	}

	function disapproved_dates($dates, $signatory, $signatory_by, $id)
	{
		if($dates) {
			$dates 			= explode(",", $dates);
			foreach($dates as $date) {
				LeaveDate::where('leave_id', '=', $id)->where('date', '=', $date)->update([$signatory => 2, $signatory_by => Auth::id()]);
				LeaveDate::where('leave_id', '=', $id)->where($signatory, '=', 0)->update([$signatory => 1, $signatory_by => Auth::id()]);
			}
		}
		else {
			LeaveDate::where('leave_id', '=', $id)->update([$signatory => 1, $signatory_by => Auth::id()]);
		}
	}
}