<?php

namespace hrmis\Http\Controllers\Reports;

use Auth;
use Carbon\Carbon;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
	public function index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$years 		= config('app.years');
		$modules 	= array('Vehicle Reservation', 'Travel Order', 'Offset', 'Overtime Request', 'DTR Override', 'Leave', 'Health Check');
		$module 	= $request->get('module') == null ? 'Vehicle Reservation' : $request->get('module');
		return view('reports.reports', compact('year', 'years', 'modules', 'module'));
	}
}