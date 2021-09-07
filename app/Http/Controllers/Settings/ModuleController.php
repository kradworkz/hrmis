<?php

namespace hrmis\Http\Controllers\Settings;

use Auth;
use hrmis\Models\Module;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
	public function index(Request $request)
	{
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$route 			= 'Modules';
		$modules 		= Module::search($search)->get();
		return view('settings.modules.modules', compact('modules', 'route', 'search'));
	}

	public function edit($id)
	{
		$module 	= Module::find($id);
		return view('settings.modules.form', compact('id', 'module'));
	}

	public function submit(Request $request, $id)
	{
		$alert 		= 'alert-info';
		$message 	= 'Module successfully updated.';
		if($request->get('is_primary') == 1) {
			Module::where('is_primary', '=', 1)->update(['is_primary' => 0]);
		}
		$module 	= Module::find($id);
		$module->update($request->all());
		return redirect()->route('Modules')->with('message', $message)->with('alert', $alert);
	}
}