<?php

namespace hrmis\Http\Controllers\Profile;

use Auth;
use hrmis\Models\EmployeeHealthCheck;
use hrmis\Http\Controllers\Profile\Controller;
use Illuminate\Http\Request;

class HealthDeclarationController extends Controller
{
	public function index(Request $request)
	{
		$route 	= 'Health Declaration';
		$date 	= $request->get('date') == null ? date('Y-m-d') : $request->get('date');
		$health = EmployeeHealthCheck::whereDate('date', '=', $date)->where('employee_id', '=', Auth::id())->latest()->first();
		return view('profile.health.health', compact('route', 'date', 'health'));
	}

	public function submit(Request $request, $id)
	{
		if($id != 0) {
			$health = EmployeeHealthCheck::find($id);
			$health->update($request->all());
		}

		return redirect()->route('Health Declaration')->with('message', 'Health Declaration successfully updated.')->with('alert', 'alert-success');
	}
}