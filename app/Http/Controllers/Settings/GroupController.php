<?php

namespace hrmis\Http\Controllers\Settings;

use Auth;
use hrmis\Models\Group;
use hrmis\Models\Employee;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
	public function index(Request $request)
	{
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$route 			= 'Groups';
		$groups 		= Group::search($search)->get();
		return view('settings.groups.groups', compact('groups', 'route', 'search'));
	}

	public function new()
	{
		$id 			= 0;
		$signatories 	= Employee::where('employee_status_id', '=', 3)->where('is_active', '=', 1)->orderBy('last_name')->get();
		$group 			= new Group;
		return view('settings.groups.form', compact('id', 'group', 'signatories'));
	}

	public function edit($id)
	{
		$group 			= Group::find($id);
		$signatories 	= Employee::where('employee_status_id', '=', 3)->where('is_active', '=', 1)->orderBy('last_name')->get();
		return view('settings.groups.form', compact('id', 'group', 'signatories'));
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New group successfully added.';
			Group::create($request->all());
		}
		else {
			$alert 		= 'alert-info';
			$message 	= 'Group successfully updated.';
			$group 		= Group::find($id);
			$group->update($request->all());
 		}
		return redirect()->route('Groups')->with('message', $message)->with('alert', $alert);
	}
}