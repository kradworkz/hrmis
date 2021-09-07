<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Employee;
use hrmis\Models\Attachment;
use hrmis\Models\Attendance;
use hrmis\Models\Notification;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\DTRValidation;
use hrmis\Http\Traits\CommentHelper;
use Illuminate\Http\Request;

class DTROverrideController extends Controller
{
	public function index(Request $request)
	{
		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			= $request->get('month') == null ? date('m') : $request->get('month');

		$years 			= config('app.years');
		$months 		= config('app.months');
		$months 		= array_except($months, "00");

		$route 			= 'DTR Override';

		$pending 		= Attendance::withoutGlobalScopes()->changed()->where('status', '!=', 2)->whereMonth('time_in', '=', $month)->whereYear('time_in', '=', $year)->where('employee_id', '=', Auth::id())->get();
		return view('profile.override.override', compact('route', 'pending', 'years', 'year', 'months', 'month'));
	}
}