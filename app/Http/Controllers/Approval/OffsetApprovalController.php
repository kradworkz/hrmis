<?php

namespace hrmis\Http\Controllers\Approval;

use Auth;
use hrmis\Models\Offset;
use hrmis\Models\Notification;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OffsetApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route 		 = 'Offset Approval';
		$status 	 = $request->get('status') ?? 0;
		$search 	 = $request->get('search') == null ? '' : $request->get('search');
		$signatory 	 = Auth::user()->offset_signatory != null ? Auth::user()->offset_signatory->signatory : null;
		$signatories = SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 3)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->offset_signatory != null) {
			$offset  = Offset::where('employee_id', '!=', Auth::id())->signatory($signatories, $signatory)->employees($search)->signature($status, $signatory)->active()->recent()->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_superuser()) {
			$offset  = Offset::employees($search)->active()->orderBy('created_at', 'desc')->paginate(50);
		}
		return view('approval.offset.offset', compact('route', 'search', 'status', 'offset'));
	}

	public function edit($id)
	{
		$offset 	= Offset::find($id);
		$approvals 	= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 3)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Offset')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.offset.form', compact('id', 'offset', 'approvals'));
	}

	public function view($id)
	{
		$offset 	= Offset::find($id);
		$approvals 	= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 3)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Offset')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.offset.view', compact('id', 'offset', 'approvals'));
	}

	public function submit(Request $request, $id)
	{
		$action 	= null;
		$offset 	= Offset::find($id);
		if($request->has('verified')) {
			$action = $request->get('verified');
			if($offset->verified != $request->get('verified')) {
				$this->submitAction($id, 3, $request->get('verified'));
			}
		}
		if($request->has('checked')) {
			$action = $request->get('checked');
			if($offset->checked != $request->get('checked')) {
				$this->submitAction($id, 3, $request->get('checked'));
			}
		}
		if($request->has('recommending')) {
			$action = $request->get('recommending');
			if($offset->recommending != $request->get('recommending')) {
				$this->submitAction($id, 3, $request->get('recommending'));
			}
		}
		if($request->has('approval')) {
			$action = $request->get('approval');
			if($offset->approval != $request->get('approval')) {
				$this->submitAction($id, 3, $request->get('approval'));
			}
		}

		if(Auth::user()->offset_signatory->signatory == 'Recommending') {
			$request->request->add(['recommending_by'           => Auth::id()]);
            $request->request->add(['recommending_notification' => 0]);
		}
		elseif(Auth::user()->offset_signatory->signatory == 'Approval') {
			$request->request->add(['approval_by'               => Auth::id()]);
            $request->request->add(['approval_notification'     => 0]);
		}
		elseif(Auth::user()->offset_signatory->signatory == 'Notification') {
			$request->request->add(['checked_by'                => Auth::id()]);
		}
		elseif(Auth::user()->offset_signatory->signatory == 'Human Resource') {
			$request->request->add(['verified_by'               => Auth::id()]);
		}

		$alert 		= 'alert-info';
		$message 	= 'Offset successfully updated.';
		$offset->update($request->all());

		if($action == 1 || $action == 2) {
			$this->newNotification(array($offset->employee->id), $offset->id, 'Offset', 'View Offset', $action == 1 ? 'Approved' : 'Disapproved');
		}
		
		$this->submitComment($id == 0 ? $offset->id : $id, 3);
		return redirect()->route('Offset Approval')->with('message', $message)->with('alert', $alert);
	}
}