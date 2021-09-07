<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use hrmis\Models\Employee;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\OvertimeRequest;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Models\OvertimeRequestPersonnel;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\OvertimeRequestValidation;
use Illuminate\Http\Request;

class OvertimeRequestController extends Controller
{
	use CommentHelper, NotificationHelper;

	public function index(Request $request)
	{
		$id 			= 0;
		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			= $request->get('month') == null ? date('m') : $request->get('month');
		$search 		= $request->get('search') == null ? '' : $request->get('search');

		$years 			= config('app.years');
		$months 		= config('app.months');
		$route 			= 'Overtime Request';
		
		$overtime_request = OvertimeRequest::tagged(Auth::id())->search($search)->year($year)->month($month)->orderBy('start_date', 'desc')->paginate(50);
		return view('profile.overtime.overtime', compact('id', 'overtime_request', 'year', 'years', 'route', 'month', 'months', 'search'));
	}

	public function new()
	{
		$id 		= 0;
		$overtime 	= new OvertimeRequest;
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		return view('profile.overtime.form', compact('id', 'overtime', 'employees'));
	}

	public function edit($id)
	{
		$overtime 	= OvertimeRequest::find($id);
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		return view('profile.overtime.form', compact('id', 'overtime', 'employees'));
	}

	public function tag($id, $employee_id = null)
	{
		$overtime    = OvertimeRequestPersonnel::where('overtime_request_id', '=', $id)->where('employee_id', '=', $employee_id == null ? Auth::id() : $employee_id)->delete();
		return redirect(URL::previous())->with('message', 'Overtime Request Tag successfully removed.')->with('alert', 'alert-success');
	}

	public function delete($id)
	{
		$overtime    = OvertimeRequest::find($id);
		$overtime->delete();
		return redirect(URL::previous())->with('message', 'Overtime Request successfully deleted.')->with('alert', 'alert-success');
	}

	public function view($id)
	{
		$overtime 	= OvertimeRequest::find($id);
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Overtime Request')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.overtime.view', compact('id', 'overtime', 'employees'));
	}

	public function status($id)
	{
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 4)->get();
		return view('layouts.status', compact('id', 'approvals'));
	}

	public function submit(OvertimeRequestValidation $request, $id)
	{
		if(Auth::user()->unit->overtime_recommending == 0) {
			$request->request->add(['recommending' => 1]);
			$request->request->add(['recommending_by' => Auth::id()]);
		}

		if(Auth::user()->unit->notification_signatory == null) {
			$request->request->add(['checked' 		=> 1]);
			$request->request->add(['checked_by' 	=> Auth::id()]);
		}
		
		$request->request->add(['employee_id' => Auth::id()]);
		$passengers 	= $request->get('overtime_personnel');
		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New overtime request successfully added.';
			$overtime 	= OvertimeRequest::create($request->all());
			$notif_tags = $passengers;
			$overtime->overtime_personnel()->attach($request->get('overtime_personnel'));
		}
		else {
			$alert      = 'alert-info';
            $message    = 'Overtime request successfully updated.';
            $overtime   = OvertimeRequest::find($id);
            $notif_tags = array_diff($passengers, $overtime->overtime_personnel->pluck('id')->toArray());
            $overtime->update($request->all());
            $overtime->overtime_personnel()->sync($request->get('overtime_personnel'));
		}

		$this->submitComment($id == 0 ? $overtime->id : $id, 4);
		$this->newNotification($notif_tags, $overtime->id, 'Overtime Request', 'View Overtime Request', 'Tag');
		return redirect()->route('Overtime Request')->with('message', $message)->with('alert', $alert);
	}
}