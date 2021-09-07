<?php

namespace hrmis\Http\Controllers\Settings;

use Auth;
use hrmis\Models\Group;
use hrmis\Models\Module;
use hrmis\Models\Employee;
use hrmis\Models\Signatory;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
	public function index(Request $request)
	{
		$route 		 = 'Signatory';
		$module_id 	 = $request->get('module') == null ? '' : $request->get('module');
		$signatories = Signatory::withCount('groups')->module($module_id)->orderBy('employee_id')->orderBy('module_id')->get();
		$modules 	 = Module::where('is_active', '=', 1)->get();
		return view('settings.signatories.signatories', compact('signatories', 'route', 'module_id', 'modules'));
	}

	public function new()
	{
		$id 			= 0;
		$signatory 		= new Signatory;
		$modules 		= Module::get();
		$employees 		= Employee::where('is_active', '=', 1)->orderBy('last_name')->get();
		$roles 			= array('Human Resource' => 'Human Resource', 'Unit Head' => 'Unit Head', 'Chief HR' => 'Chief HR', 'Recommending' => 'Recommending', 'Recommending FAS' => 'Recommending FAS', 'Approval' => 'Approval', 'Notification' => 'Notification');
		$groups 		= Group::where('is_active', '=', 1)->get();
		return view('settings.signatories.form', compact('id', 'signatory', 'employees', 'modules', 'roles', 'groups'));
	}

	public function edit($id)
	{
		$signatory 		= Signatory::find($id);
		$modules 		= Module::get();
		$employees 		= Employee::where('is_active', '=', 1)->orderBy('last_name')->get();
		$roles 			= array('Human Resource' => 'Human Resource', 'Unit Head' => 'Unit Head', 'Chief HR' => 'Chief HR', 'Recommending' => 'Recommending', 'Recommending FAS' => 'Recommending FAS', 'Approval' => 'Approval', 'Notification' => 'Notification');
		$groups 		= Group::where('is_active', '=', 1)->get();
		return view('settings.signatories.form', compact('id', 'signatory', 'employees', 'modules', 'roles', 'groups'));
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert          = 'alert-success';
            $message        = 'New signatory successfully added.';
            $signatory      = Signatory::create($request->all());
            $signatory->groups()->attach($request->get('groups'));
		}
		else {
			$alert          = 'alert-info';
            $message        = 'Signatory successfully updated.';
            $signatory      = Signatory::find($id);
            $signatory->update($request->all());
            $signatory->groups()->sync($request->get('groups'));
		}

		return redirect()->route('Signatory')->with('message', $message)->with('alert', $alert);
	}
}