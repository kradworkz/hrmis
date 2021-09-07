<?php

namespace hrmis\Http\Controllers\HR;

use Auth;
use hrmis\Models\Group;
use hrmis\Models\JobContract;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractController extends Controller
{
	public function index(Request $request)
	{
		$years 		= config('app.years');
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$route 		= 'Employee Job Contract';
		$contracts 	= JobContract::active()->year($year)->paginate(100);
		$contracts = $contracts->sortBy(function($query) {
			return $query->employee->last_name;
		})->all();

		return view('hr.contract.contract', compact('route', 'contracts', 'years', 'year'));
	}
}