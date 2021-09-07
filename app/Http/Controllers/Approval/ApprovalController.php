<?php

namespace hrmis\Http\Controllers\Approval;

use Auth;
use Carbon\Carbon;
use hrmis\Models\Group;
use hrmis\Models\Module;
use hrmis\Models\Leave;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Signatory;
use hrmis\Models\Reservation;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\OvertimeRequest;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
	public function index(Request $request)
	{
		$route 			= 'Approval';
		$quarter_id 	= $request->get('quarter_id') ?? 1;
		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		if($quarter_id == 1) {
			$start 	= Carbon::createFromDate($year, 01)->startOfMonth();
			$end 	= Carbon::createFromDate($year, 03)->lastOfMonth();
		}
		elseif($quarter_id == 2) {
			$start 	= Carbon::createFromDate($year, 04)->startOfMonth();
			$end 	= Carbon::createFromDate($year, 06)->lastOfMonth();
		}
		elseif($quarter_id == 3) {
			$start 	= Carbon::createFromDate($year, 07)->startOfMonth();
			$end 	= Carbon::createFromDate($year, 9)->lastOfMonth();
		}
		elseif($quarter_id == 4) {
			$start 	= Carbon::createFromDate($year, 10)->startOfMonth();
			$end 	= Carbon::createFromDate($year, 12)->lastOfMonth();
		}

		$years 			= config('app.years');
		$modules 		= Module::get();
		$signatory 		= Signatory::where('employee_id', '=', Auth::id())->get();
		$signatories 	= Signatory::groupBy('employee_id')->orderBy('module_id')->get();
		$reservations 	= Reservation::where(function($query) {
							$query->where('checked_by', Auth::id())->orWhere('recommending_by', Auth::id())->orWhere('approval_by', Auth::id());
						})->whereBetween('created_at', [$start, $end])->whereYear('created_at', $year)->count();
		$travels 		= Travel::where(function($query) {
							$query->where('checked_by', Auth::id())->orWhere('recommending_by', Auth::id())->orWhere('approval_by', Auth::id());
						})->whereBetween('created_at', [$start, $end])->whereYear('created_at', $year)->count();
		$offset 		= Offset::where(function($query) {
							$query->where('recommending_by', Auth::id())->orWhere('approval_by', Auth::id());
						})->whereBetween('created_at', [$start, $end])->whereYear('created_at', $year)->count();
		$leave 			= Leave::where(function($query) {
							$query->where('chief_approval_by', Auth::id())->orWhere('recommending_by', Auth::id())->orWhere('approval_by', Auth::id());
						})->whereBetween('created_at', [$start, $end])->whereYear('created_at', $year)->count();
		$overtime 		= OvertimeRequest::where(function($query) {
							$query->where('checked_by', Auth::id())->orWhere('recommending_by', Auth::id())->orWhere('approval_by', Auth::id());
						})->whereBetween('created_at', [$start, $end])->whereYear('created_at', $year)->count();

		return view('approval.approval', compact('signatory', 'route', 'signatories', 'travels', 'reservations', 'leave', 'offset', 'overtime', 'quarter_id', 'years', 'year', 'start', 'end'));
	}
}