<?php

namespace hrmis\Http\Controllers\Approval;

use Auth, Carbon\Carbon;
use hrmis\Models\Vehicle;
use hrmis\Models\Employee;
use hrmis\Models\Reservation;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\SignatoryGroup;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Traits\ApprovalStatusHelper;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleApprovalController extends Controller
{
	use CommentHelper, ApprovalStatusHelper, NotificationHelper;

	public function index(Request $request)
	{
		$route  	 = 'Vehicle Approval';
		$status 	 = $request->get('status') ?? 0;
		$search 	 = $request->get('search') == null ? '' : $request->get('search');
		$signatory 	 = Auth::user()->reservation_signatory != null ? Auth::user()->reservation_signatory->signatory : null;
		$signatories = SignatoryGroup::whereHas('signatory', function($signatories) {
            $signatories->where('module_id', '=', 1)->where('employee_id', '=', Auth::id());
        })->pluck('group_id');

		if(Auth::user()->reservation_signatory != null) {
			$reservations = Reservation::location()->signatory($signatories)->employees($search)->signature($status, $signatory)->approved()->active()->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_assistant()) {
			$reservations = Reservation::whereHas('vehicle', function($vehicle) {
				$vehicle->where('location', '=', 1);
			})->employees($search)->active()->where('status', '=', $status)->recent()->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_health_officer()) {
			$reservations = Reservation::whereDate('start_date', '>', '2020-06-07')->employees($search)->active()->where('check', '=', $status)->orderBy('created_at', 'desc')->paginate(50);
		}
		elseif(Auth::user()->is_superuser()) {
			$reservations = Reservation::employees($search)->active()->orderBy('created_at', 'desc')->paginate(50);
		}

		return view('approval.reservations.reservations', compact('route', 'reservations', 'status', 'search', 'search'));
	}

	public function new()
	{
		$id 		 = 0;
		$reservation = new Reservation;
		$vehicles 	 = Vehicle::where('is_active', '=', 1)->get();
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$approvals 	 = ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 1)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Vehicle Reservation')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.reservations.form', compact('id', 'reservation', 'vehicles', 'employees', 'approvals'));
	}

	public function edit($id)
	{
		$reservation = Reservation::find($id);
		$vehicles 	 = Vehicle::where('is_active', '=', 1)->get();
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$approvals 	 = ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 1)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Vehicle Reservation')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.reservations.form', compact('id', 'reservation', 'vehicles', 'employees', 'approvals'));
	}

	public function view($id)
	{
		$reservation = Reservation::find($id);
		$vehicles 	 = Vehicle::where('is_active', '=', 1)->get();
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$approvals 	 = ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 1)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Vehicle Reservation')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('approval.reservations.view', compact('id', 'reservation', 'vehicles', 'employees', 'approvals'));
	}

	public function submit(Request $request, $id)
	{
		$action = null;
		$request->request->add(['location' => Auth::user()->unit->location == 0 ? 1 : 0]);

		if($id == 0) {
			$request->request->add(['employee_id' => Auth::id()]);
			$reservation 	= Reservation::create($request->all());
			$reservation->passengers()->attach($request->get('passengers'));
			$alert          = 'alert-success';
            $message        = 'New vehicle reservation successfully added.';
		}
		else {
            $alert          = 'alert-info';
            $message        = 'Reservation successfully updated.';
            $reservation 	= Reservation::find($id);

            if($request->has('check')) {
            	$action = $request->get('check');
            	$request->request->add(['checked_by' 		=> Auth::id()]);
            	if($reservation->check != $request->get('check')) {
            		$this->submitAction($id, 1, $request->get('check'));
            	}
            }
			if($request->has('status')) {
				$action = $request->get('status');
				$request->request->add(['status_by' 		=> Auth::id()]);
				if($reservation->status != $request->get('status')) {
            		$this->submitAction($id, 1, $request->get('status'));
            	}
			}
			if($request->has('recommending')) {
				$action = $request->get('recommending');
				$request->request->add(['recommending_by' 	=> Auth::id()]);
				if($reservation->recommending != $request->get('recommending')) {
            		$this->submitAction($id, 1, $request->get('recommending'));
            	}
			}
			if($request->has('approval')) {
				$action = $request->get('approval');
				$request->request->add(['approval_by' 		=> Auth::id()]);
				if($reservation->approval != $request->get('approval')) {
            		$this->submitAction($id, 1, $request->get('approval'));
            	}
			}

            $reservation->update($request->all());
            if($request->has('passengers')) {
            	$reservation->passengers()->sync($request->get('passengers'));
            }
		}
		
		if($action == 1 || $action == 2) {
			$this->newNotification(array($reservation->employee->id), $reservation->id, 'Vehicle Reservation', 'View Reservation', $action == 1 ? 'Approved' : 'Disapproved');
		}

		$this->submitComment($id == 0 ? $reservation->id : $id, 1);
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}
}