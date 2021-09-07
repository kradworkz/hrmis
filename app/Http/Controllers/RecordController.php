<?php

namespace hrmis\Http\Controllers;

use Auth;
use hrmis\Models\Group;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use Illuminate\Http\Request;

class RecordController extends Controller
{
	public function index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');
		$module 	= $request->get('module') ?: 'Travel Order';
		$search 	= $request->get('search') == null ? '' : $request->get('search');
		$group_id 	= $request->get('group_id');
		$years 		= config('app.years');
		$months 	= config('app.months');
		$route 		= 'Records List';
		$groups 	= Group::where('location', '=', 0)->get();

		if ($module == 'Travel Order') {
			$records = Travel::active()->location($group_id)->year($year)->month($month)->search($search)->orderBy('start_date', 'desc')->paginate(50);
		}

		return view('records.records', compact('year', 'years', 'month', 'months', 'search', 'route', 'records', 'groups', 'module', 'group_id'));
	}
}