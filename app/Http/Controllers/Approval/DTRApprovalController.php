<?php

namespace hrmis\Http\Controllers\Approval;

use Auth, URL;
use Carbon\Carbon;
use hrmis\Models\Employee;
use hrmis\Models\Attendance;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DTRApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{	
		$route 		 	= 'DTR Approval';
		$status 	 	= $request->get('status') ?? 0;
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$dtr 			= Attendance::withoutGlobalScopes()->changed()->where('status', '=', $status)->orderBy('time_in', 'desc')->paginate(50);
		return view('approval.dtr.dtr', compact('route', 'search', 'status', 'dtr'));
	}

	public function new()
	{
		$id 			= 0;
		$dtr 			= new Attendance;
		$employees 		= Employee::where('is_active', '=', 1)->orderBy('last_name')->get();
		return view('approval.dtr.form', compact('id', 'dtr', 'employees'));
	}

	public function edit($id)
	{
		$dtr 			= Attendance::withoutGlobalScopes()->find($id);
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Attendance')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.dtr.form', compact('id', 'dtr'));
	}

	public function view($id)
	{
		$dtr 			= Attendance::withoutGlobalScopes()->find($id);
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Attendance')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.dtr.view', compact('id', 'dtr'));
	}

	public function delete($id)
	{
		$dtr    		= Attendance::withoutGlobalScopes()->find($id);
		$dtr->delete();
		return redirect(URL::previous())->with('message', 'DTR successfully deleted.')->with('alert', 'alert-success');
	}

	public function approve($id, $action)
	{
		$message 	= 'DTR successfully updated.';
		$alert 	 	= 'alert-info';
		$dtr 		= Attendance::withoutGlobalScopes()->find($id);
		Attendance::where('employee_id', '=', $dtr->employee_id)->whereDate('time_in', '=', $dtr->time_in->format('Y-m-d'))->update(['status' => 2, 'updated_by' => Auth::id()]);
		$dtr->update(['status' => $action, 'updated_by' => Auth::id()]);
		return redirect()->route('DTR Approval')->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		$action 		= $request->get('status');
		$request->request->add(['updated_by' 	=> Auth::id()]);
		$request->request->add(['time_in' 		=> $request->get('time_in') != null ? ($request->get('date')." ".$request->get('time_in')).":".date('s') : null]);
		$request->request->add(['time_out' 		=> $request->get('time_out') != null ? ($request->get('date')." ".$request->get('time_out')).":".date('s') : null]);

		if($id == 0) {
			$alert      = 'alert-success';
		    $message    = 'Daily Time Record successfully added.';
		    $dtr   		= Attendance::create($request->all());
		}
		else {
			$alert   	= 'alert-success';
			$message	= 'Daily Time Record successfully updated.';
			$dtr 		= Attendance::withoutGlobalScopes()->find($id);

			if($action == 1 && $dtr->status != 1) {
				Attendance::where('employee_id', '=', $request->get('employee_id'))->whereDate('time_in', '=', $request->get('date'))->update(['status' => 2, 'updated_by' => Auth::id()]);
			}

			$dtr->update(['status' => $action, 'updated_by' => Auth::id()]);

			if($action == 1 || $action == 2) {
				$this->newNotification(array($dtr->employee->id), $dtr->id, 'Attendance', 'View Daily Time Record', $action == 1 ? 'Approved' : 'Disapproved');
			}
		}

		$this->submitComment($id == 0 ? $dtr->id : $id, 5);
		return redirect()->route('DTR Approval')->with('message', $message)->with('alert', $alert);
	}
}