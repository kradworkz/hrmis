<?php

namespace hrmis\Http\Controllers\Whereabouts;

use Auth;
use Carbon\Carbon;
use hrmis\Models\Group;
use hrmis\Models\Travel;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhereaboutController extends Controller
{
	public function index(Request $request)
	{
		$input_date  	= $request->get('date') == null ? date('m/d/Y') : Carbon::parse($request->get('date'))->format('m/d/Y');
		$search 		= $request->get('search');
		$date 			= Carbon::parse($input_date);
		$groups 		= Group::where('is_active', '=', 1)->employees($search)->where('whereabouts', '=', 1)->get();
		$start 			= $date->subDays(3);
		$end 			= $date->addDays(3);
		$travels 		= Travel::where('is_active', '=', 1)->where('start_date', '<=', $date->format('Y-m-d'))->where('end_date', '>=', $date->format('Y-m-d'))->get();
		return view('whereabouts.whereabouts', compact('groups', 'input_date', 'date', 'travels'));
	}
}