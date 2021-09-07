<?php

namespace hrmis\Http\Controllers\Approval;

use Auth;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use hrmis\Models\Notification;
use hrmis\Models\TravelExpense;
use hrmis\Models\TravelFundExpense;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravelApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route  	 = 'Travel Approval';
		$status 	 = $request->get('status') ?? 0;
		$search 	 = $request->get('search') == null ? '' : $request->get('search');
		$signatory 	 = Auth::user()->travel_signatory != null ? Auth::user()->travel_signatory->signatory : null;
		$signatories = SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 2)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->travel_signatory != null) {
			$travels = Travel::where('employee_id', '!=', Auth::id())->signatory($signatories, $signatory)->employees($search)->signature($status, $signatory)->active()->recent()->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_superuser()) {
			$travels = Travel::employees($search)->where('is_active', '=', 1)->orderBy('created_at', 'desc')->paginate(50);
		}
		
		return view('approval.travels.travels', compact('route', 'travels', 'status', 'search'));
	}

	public function edit($id)
	{
		$travel 	 = Travel::find($id);
		$expenses  	 = TravelExpense::where('id', '!=', 3)->get();
		$tfexpenses  = TravelFundExpense::select(\DB::raw("*, CONCAT(expense_id,',',fund_id) as tfexpenses"))->where('travel_id', '=', $id)->pluck('tfexpenses')->toArray();
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$approvals 	 = ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 2)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Travel Order')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.travels.form', compact('id', 'travel', 'expenses', 'employees', 'tfexpenses', 'approvals'));
	}

	public function view($id)
	{
		$travel 	 = Travel::find($id);
		$expenses  	 = TravelExpense::where('id', '!=', 3)->get();
		$tfexpenses  = TravelFundExpense::select(\DB::raw("*, CONCAT(expense_id,',',fund_id) as tfexpenses"))->where('travel_id', '=', $id)->pluck('tfexpenses')->toArray();
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$approvals 	 = ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 2)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Travel Order')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.travels.view', compact('id', 'travel', 'expenses', 'employees', 'tfexpenses', 'approvals'));
	}

	public function submit(Request $request, $id)
	{
		$action = null;
		$travel = Travel::find($id);
		if($request->has('recommending')) {
			$action = $request->get('recommending');
			if($travel->recommending != $request->get('recommending')) {
				$this->submitAction($id, 2, $request->get('recommending'));
			}
		}
		if($request->has('approval')) {
			$action = $request->get('approval');
			if($travel->approval != $request->get('approval')) {
				$this->submitAction($id, 2, $request->get('approval'));
			}
		}

		if(Auth::user()->travel_signatory->signatory == 'Recommending') {
			$request->request->add(['recommending_by'           => Auth::id()]);
            $request->request->add(['recommending_notification' => 0]);
		}
		elseif(Auth::user()->travel_signatory->signatory == 'Approval') {
			$request->request->add(['approval_by'               => Auth::id()]);
            $request->request->add(['approval_notification'     => 0]);
		}
		else {
			$request->request->add(['checked_by'                => Auth::id()]);
		}

		$alert 		= 'alert-info';
		$message 	= 'Travel successfully updated.';
		$travel->update($request->all());

		if($action == 1 || $action == 2) {
			$this->newNotification(array($travel->employee->id), $travel->id, 'Travel Order', 'View Travel Order', $action == 1 ? 'Approved' : 'Disapproved');
		}
		
		$this->submitComment($id == 0 ? $travel->id : $id, 2);
		return redirect()->route('Travel Approval')->with('message', $message)->with('alert', $alert);
	}
}