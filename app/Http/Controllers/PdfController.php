<?php

namespace hrmis\Http\Controllers;

use Auth, PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Leave;
use hrmis\Models\Offset;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use hrmis\Models\LeaveDate;
use hrmis\Models\Reservation;
use hrmis\Models\TravelExpense;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\OvertimeRequest;

class PdfController extends Controller
{
	public function travels($id)
	{
		$travel 			= Travel::find($id);
		$expenses   		= TravelExpense::where('id', '!=', 3)->get();
		$recommending 		= null;
		$approval 			= null;
		if($travel->employee->unit->travel_recommending == 1) {
			$recommending 	= SignatoryGroup::where('group_id', '=', $travel->employee->unit->id)->module(2, 'Recommending')->first();
		}
		if($travel->employee->unit->travel_approval == 1) {
			$approval 		= SignatoryGroup::where('group_id', '=', $travel->employee->unit->id)->module(2, 'Approval')->first();
		}
		$view 				= view('pdf.travels', compact('travel', 'expenses', 'recommending', 'approval'));
		$pdf  				= PDF::loadHTML($view);
		return $pdf->inline();
	}

	public function leave($id)
	{

		$leave 				= Leave::find($id);
		$chief 				= null;
		$recommending 		= null;
		$approval 			= null;
		if($leave->employee->unit->chief_approval == 1) {
			$chief 			= SignatoryGroup::where('group_id', '=', $leave->employee->unit->id)->module(6, 'Chief HR')->first();
		}
		if($leave->employee->unit->leave_recommending == 1) {
			$recommending 	= SignatoryGroup::where('group_id', '=', $leave->employee->unit->id)->module(6, 'Recommending')->first();
		}
		if($leave->employee->unit->leave_approval == 1) {
			$approval 		= SignatoryGroup::where('group_id', '=', $leave->employee->unit->id)->module(6, 'Approval')->first();
		}
		$ard_dates 			= LeaveDate::where('leave_id', '=', $id)->where('recommending', '=', 2)->get();
		$rd_dates 			= LeaveDate::where('leave_id', '=', $id)->where('approval', '=', 2)->get();
		$view 				= view('pdf.leave', compact('leave', 'chief', 'recommending', 'approval', 'ard_dates', 'rd_dates'));
		$pdf 				= PDF::loadHTML($view);
		return $pdf->inline();
	}

	public function travel_order_report($id, $year)
	{
		$employee 	= Employee::find($id);
    	$travels    = Travel::tagged($id)->whereYear('start_date', '=', $year)->latest('start_date', 'desc')->get();
    	$view 		= view('pdf.reports.travels', compact('travels', 'employee'));
		$dtr        = PDF::loadHTML($view, 'dtr');
        return $dtr->inline();
	}

	public function ticket($id)
	{
		$reservation 		= Reservation::find($id);
		$recommending 		= null;
		$approval 			= null;
		if($reservation->vehicle->location == 1) {
			$recommending 	= SignatoryGroup::module(1, 'Recommending')->first();
			$approval 		= SignatoryGroup::module(1, 'Approval')->first();
		}
		else {
			if($reservation->employee->unit->recommending == 1) {
				$recommending 	= SignatoryGroup::where('group_id', '=', $reservation->employee->unit->id)->module(1, 'Recommending')->first();
			}
			if($reservation->employee->unit->approval == 1) {
				$approval 		= SignatoryGroup::where('group_id', '=', $reservation->employee->unit->id)->module(1, 'Approval')->first();
			}
		}

		$view 		 		= view('pdf.ticket', compact('reservation', 'recommending', 'approval'));
		$pdf  		 		= PDF::loadHTML($view);
		return $pdf->inline();
	}

	public function offset($id)
	{
		$offset 			= Offset::find($id);
		$recommending 		= null;
		$approval 			= null;
		if($offset->employee->unit->offset_recommending == 1) {
			$recommending 	= SignatoryGroup::where('group_id', '=', $offset->employee->unit->id)->module(3, 'Recommending')->first();
		}
		if($offset->employee->unit->offset_approval == 1) {
			$approval 		= SignatoryGroup::where('group_id', '=', $offset->employee->unit->id)->module(3, 'Approval')->first();
		}
		$view 				= view('pdf.offset', compact('offset', 'recommending', 'approval'));
		$pdf 				= PDF::loadHTML($view);
		return $pdf->inline();
	}

	public function offset_report($id, $year)
	{
		$employee 	= Employee::find($id);
    	$offset     = Offset::where('employee_id', '=', $id)->whereYear('date', '=', $year)->latest('date', 'desc')->get();
    	$view 		= view('pdf.reports.offset', compact('offset', 'employee'));
		$dtr        = PDF::loadHTML($view, 'dtr');
        return $dtr->inline();
	}

	public function overtime($id)
	{
		$overtime 			= OvertimeRequest::find($id);
		$recommending 		= null;
		$approval 			= null;
		if($overtime->employee->unit->overtime_recommending == 1) {
			$recommending 	= SignatoryGroup::where('group_id', '=', $overtime->employee->unit->id)->module(4, 'Recommending')->first();
		}
		if($overtime->employee->unit->overtime_approval == 1) {
			$approval 		= SignatoryGroup::where('group_id', '=', $overtime->employee->unit->id)->module(4, 'Approval')->first();
		}
		$view 				= view('pdf.overtime', compact('overtime', 'recommending', 'approval'));
		$pdf 				= PDF::loadHTML($view);
		return $pdf->inline();
	}

	public function dtr($id, $start, $end, $mode = 0)
	{
		$employee 			= Employee::find($id);
		if($mode == 0) {
			$start_date 	= Carbon::parse($start);
			$end_date 		= Carbon::parse($end);
		}
		else {
			$start_date 	= Carbon::createFromDate($start, $end, 1)->firstOfMonth();
			$end_date 		= Carbon::createFromDate($start, $end, 1)->lastOfMonth();
		}
		
		$days 				= CarbonPeriod::create($start_date, $end_date);
		$view 				= view('pdf.dtr', compact('id', 'employee', 'days', 'start_date', 'end_date'));
		$pdf 				= PDF::loadHTML($view);
		return $pdf->inline();
	}
}