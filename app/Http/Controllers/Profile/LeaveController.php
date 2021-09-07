<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Leave;
use hrmis\Models\LeaveDate;
use hrmis\Models\LeaveCredit;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Requests\LeaveValidation;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
	use CommentHelper;

	public function index(Request $request)
	{
		$id 		= 0;
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');
		$search 	= $request->get('search') == null ? '' : $request->get('search');

		$years 		= config('app.years');
		$months 	= config('app.months');
		$route 		= 'Leave';

		$leave 		= Leave::where('employee_id', '=', Auth::id())->year($year)->month($month)->paginate(50);
		return view('profile.leave.leave', compact('id', 'leave', 'year', 'years', 'route', 'months', 'month', 'search'));
	}

	public function new()
	{
		$id 		= 0;
		$leave 		= new Leave;
		return view('profile.leave.form', compact('id', 'leave'));
	}

	public function edit($id)
	{
		$leave 				= Leave::find($id);
		$approvals 			= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 6)->get();
		$disapproved_dates 	= LeaveDate::where('leave_id', '=', $id)->where(function($query) {
								$query->where('chief_approval', '=', 2)->orWhere('recommending', '=', 2)->orWhere('approval', '=', 2);
							})->get();
		return view('profile.leave.form', compact('id', 'leave', 'approvals', 'disapproved_dates'));
	}

	public function view($id)
	{
		$leave 				= Leave::find($id);
		$approvals 			= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 6)->get();
		$disapproved_dates 	= LeaveDate::where('leave_id', '=', $id)->where(function($query) {
			$query->where('chief_approval', '=', 2)->orWhere('recommending', '=', 2)->orWhere('approval', '=', 2);
		})->get();
		return view('profile.leave.view', compact('id', 'leave', 'approvals', 'disapproved_dates'));
	}

	public function delete($id)
	{
		$leave    	= Leave::find($id);
		$leave->leave_dates()->delete();
		$leave_credit = LeaveCredit::where('leave_id', '=', $id)->delete();
		$leave->delete();
		return redirect(URL::previous())->with('message', 'Leave successfully deleted.')->with('alert', 'alert-success');
	}

	public function submit(LeaveValidation $request, $id)
	{
		$days  		= array();
		$dates 		= CarbonPeriod::create(Carbon::parse($request->get('start_date')), Carbon::parse($request->get('end_date')));

		if($id == 0) {
			$credit = Auth::user()->leave_credits;
		}
		else {
			$credit = LeaveCredit::where('employee_id', '=', Auth::id())->where('id', '<', Auth::user()->leave_credits->id)->latest()->first();
		}

		if(!$credit) {
			$vl_credit 	= 0;
			$sl_credit 	= 0;
		}
		else {
			$vl_credit 	= $credit->vl_balance;
			$sl_credit 	= $credit->sl_balance;
		}
		

		foreach($dates as $date) {
			if($date->isWeekday()) {
				$days[] = $date;
			}
		}

		$day_count = count($days);

		if($request->has('time') && $request->get('time') != 'Whole Day') {
			$day_count = $day_count/2;
		}

		$request->request->add(['employee_id' => Auth::id()]);
		$request->request->add(['number_of_working_days_applied' => $day_count]);
		if($request->get('type') == 'Sick Leave') {
			$balance = $sl_credit-$day_count;
			if($balance < 0) {
				$balance = abs($balance);
				$request->request->add(['approved_without_pay' 	=> $balance]);
				$request->request->add(['approved_sick_leave' 	=> $day_count-$balance]);
				$balance = 0;
			}
			else {
				$request->request->add(['approved_sick_leave' 	=> $day_count]);
			}
			$request->request->add(['approved_vacation_leave' 	=> 0]);
		}
		elseif($request->get('type') == 'Vacation Leave') {
			$balance = $vl_credit-$day_count;
			if($balance < 0) {
				$balance = abs($balance);
				$request->request->add(['approved_without_pay' 		=> $balance]);
				$request->request->add(['approved_vacation_leave' 	=> $day_count-$balance]);
				$balance = 0;
			}
			else {
				$request->request->add(['approved_vacation_leave' 	=> $day_count]);
			}
			$request->request->add(['approved_sick_leave' 			=> 0]);
		}
		else {
			$balance = null;
		}

		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New leave successfully added.';
			$leave 		= Leave::create($request->except(['comment', 'Submit']));

			foreach($days as $day) {
				LeaveDate::create([
					'leave_id' 	=> $leave->id,
					'date' 		=> $day,
				]);
			}

			$leave_credit = new LeaveCredit;
			$this->create_leave_credit($leave_credit, $leave, $balance, $sl_credit, $vl_credit);
			$leave_credit->save();
		}
		else {
			$alert 		= 'alert-info';
			$message 	= 'Leave successfully updated.';
			$leave 		= Leave::find($id);
			$leave->update($request->except(['comment', 'Submit']));
			$leave->leave_dates()->delete();

			foreach($days as $day) {
				LeaveDate::create([
					'leave_id' 	=> $leave->id,
					'date' 		=> $day,
				]);
			}
			
			$leave_credit = LeaveCredit::where('employee_id', '=', $leave->employee_id)->where('leave_id', '=', $leave->id)->latest()->first();
			$this->create_leave_credit($leave_credit, $leave, $balance, $sl_credit, $vl_credit);
			$leave_credit->save();
		}
		
		$this->submitComment($id == 0 ? $leave->id : $id, 6);
		return redirect()->route('Leave')->with('message', $message)->with('alert', $alert);
	}

	function create_leave_credit($leave_credit, $leave, $balance, $sl_credit, $vl_credit)
	{
		if($leave->type == 'Sick Leave') {
			$leave_credit->employee_id 				= $leave->employee_id;
			$leave_credit->leave_id 				= $leave->id;
			$leave_credit->vl_deduct 				= NULL;
			$leave_credit->vl_deduct_without_pay 	= NULL;
			$leave_credit->vl_balance 				= $vl_credit;
			$leave_credit->sl_deduct 				= $leave->approved_sick_leave;
			$leave_credit->sl_deduct_without_pay 	= $leave->approved_without_pay;
			$leave_credit->sl_balance 				= $balance;
			$leave_credit->month 					= Carbon::now()->format('m');
			$leave_credit->year 					= Carbon::now()->format('Y');
		}
		elseif($leave->type == 'Vacation Leave') {
			$leave_credit->employee_id 				= $leave->employee_id;
			$leave_credit->leave_id 				= $leave->id;
			$leave_credit->vl_deduct 				= $leave->approved_vacation_leave;
			$leave_credit->vl_deduct_without_pay 	= $leave->approved_without_pay;
			$leave_credit->vl_balance 				= $balance;
			$leave_credit->sl_deduct 				= NULL;
			$leave_credit->sl_deduct_without_pay 	= NULL;
			$leave_credit->sl_balance 				= $sl_credit;
			$leave_credit->month 					= Carbon::now()->format('m');
			$leave_credit->year 					= Carbon::now()->format('Y');
		}
		else {
			$leave_credit->employee_id 				= $leave->employee_id;
			$leave_credit->leave_id 				= $leave->id;
			$leave_credit->vl_deduct 				= NULL;
			$leave_credit->vl_deduct_without_pay 	= NULL;
			$leave_credit->vl_balance 				= $vl_credit;
			$leave_credit->sl_deduct 				= NULL;
			$leave_credit->sl_deduct_without_pay 	= NULL;
			$leave_credit->sl_balance 				= $sl_credit;
			$leave_credit->month 					= Carbon::now()->format('m');
			$leave_credit->year 					= Carbon::now()->format('Y');
		}
	}
}